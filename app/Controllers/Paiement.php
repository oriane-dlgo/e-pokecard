<?php

namespace App\Controllers;

use App\Models\CommandesModel;
use App\Libraries\Payment\PaymentFactory;

/**
 * Contrôleur gérant le processus de paiement (Design Pattern Strategy)
 */
class Paiement extends BaseController
{
    /**
     * Étape 1 : Choix du mode de paiement
     */
    public function choix($idCommande)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $commandeModel = new CommandesModel();
        
        // Vérification que la commande appartient bien à l'user connecté
        $commande = $commandeModel->getCommandeUtilisateur($idCommande, session()->get('id'));

        if (!$commande) {
            return redirect()->to('/profil')->with('msg', 'Commande introuvable ou accès refusé.');
        }

        return view('confirmation/paiement', [
            'commande'     => $commande,
            'total_global' => $commande->total
        ]);
    }

    /**
     * Étape 2 : Traitement du paiement
     */
    public function process()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        // 1. Validation des inputs
        $rules = [
            'commande_id'   => 'required|integer',
            'type_paiement' => 'required|in_list[card,paypal]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('msg', 'Données de paiement invalides.');
        }

        $commandeId   = $this->request->getPost('commande_id');
        $typePaiement = $this->request->getPost('type_paiement');

        try {
            // 2. Appel de la Factory pour obtenir la bonne stratégie
            $strategy = PaymentFactory::create($typePaiement);
            
            // 3. Exécution du paiement (Mise à jour BDD via le modèle appelé par la stratégie)
            $strategy->pay((int)$commandeId);

            return redirect()->to('/commande/confirmation/' . $commandeId)
                ->with('success', 'PAIEMENT ACCEPTÉ ! MERCI DRESSEUR.');

        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'ERREUR TERMINAL : ' . $e->getMessage());
        }
    }
}