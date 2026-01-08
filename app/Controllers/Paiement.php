<?php

namespace App\Controllers;

use App\Models\CommandesModel;


interface PaymentStrategyInterface {
    public function pay(int $commandeId): void;
}

abstract class BasePaymentStrategy implements PaymentStrategyInterface {
    protected $db;
    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    protected function completeOrder(int $commandeId, string $label): void {
        $this->db->table('commandes')
            ->where('id', $commandeId)
            ->update([
                'type_paiement' => $label,
                'statut'        => 'validee'
            ]);
    }
}

class CreditCardPayment extends BasePaymentStrategy {
    public function pay(int $commandeId): void {
        $this->completeOrder($commandeId, 'Credit Card');
    }
}

class PayPalPayment extends BasePaymentStrategy {
    public function pay(int $commandeId): void {
        $this->completeOrder($commandeId, 'Paypal');
    }
}

class PaymentFactory {
    public static function create(string $type): PaymentStrategyInterface {
        return match(strtolower($type)) {
            'card'   => new CreditCardPayment(),
            'paypal' => new PayPalPayment(),
            default  => throw new \Exception("Mode inconnu"),
        };
    }
}

class Paiement extends BaseController
{
    public function choix($idCommande)
    {
        $commandeModel = new CommandesModel();
        $commande = $commandeModel->find($idCommande);

        if (!$commande || $commande->id_user != session()->get('id')) {
            return redirect()->to('/panier')->with('msg', 'Commande introuvable.');
        }

        return view_theme('paiement_retro', [
            'commande'     => $commande,
            'total_global' => $commande->total
        ]);
    }

    public function process()
    {
        $commandeId   = $this->request->getPost('commande_id');
        $typePaiement = $this->request->getPost('type_paiement');

        try {
            $strategy = PaymentFactory::create($typePaiement);
            $strategy->pay((int)$commandeId);

            return redirect()->to('/commande/confirmation/' . $commandeId)
                ->with('success', 'PAIEMENT REÇU !');

        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'ERREUR DE TERMINAL : ' . $e->getMessage());
        }
    }
}