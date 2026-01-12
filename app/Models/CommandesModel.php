<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Commandes;

class CommandesModel extends Model
{
    protected $table            = 'commandes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Commandes::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user','date_creation','statut','total','type_paiement'];

    // --- LOGIQUE DU MEMENTO PATTERN ---

    /**
     * Sauvegarde l'état actuel en session avant modification
     */
    public function saveMementoToSession(int $id): bool
    {
        $commande = $this->find($id);
        if (!$commande) return false;

        $session = session();
        $mementos = $session->get('commandes_mementos') ?? [];

        // On capture l'état (le Memento)
        $mementos[$id] = [
            'statut'        => $commande->statut,
            'type_paiement' => $commande->type_paiement,
            'saved_at'      => time()
        ];

        $session->set('commandes_mementos', $mementos);
        return true;
    }

    /**
     * Restaure l'état depuis la session (Undo)
     */
    public function restoreMementoFromSession(int $id): bool
    {
        $session = session();
        $mementos = $session->get('commandes_mementos');

        if ($mementos && isset($mementos[$id])) {
            $oldData = $mementos[$id];

            // Restauration en base de données
            $updateSuccess = $this->update($id, [
                'statut'        => $oldData['statut'],
                'type_paiement' => $oldData['type_paiement']
            ]);

            if ($updateSuccess) {
                // On nettoie le memento utilisé
                unset($mementos[$id]);
                $session->set('commandes_mementos', $mementos);
                return true;
            }
        }
        return false;
    }

    /**
     * Récupère une commande spécifique d'un utilisateur (Sécurité)
     */
    public function getCommandeUtilisateur($idCommande, $idUser)
    {
        return $this->where('id', $idCommande)
                    ->where('id_user', $idUser)
                    ->first();
    }

    /**
     * Récupère l'historique complet AVEC le nombre d'articles calculé
     */
    public function getHistoriqueWithCount($idUser)
    {
        return $this->select('commandes.*, COUNT(lignes_commande.id) as nb_articles')
                    ->join('lignes_commande', 'lignes_commande.commande_id = commandes.id', 'left')
                    ->where('id_user', $idUser)
                    ->groupBy('commandes.id')
                    ->orderBy('date_creation', 'DESC')
                    ->findAll();
    }

    /**
     * Finalise le paiement d'une commande
     */
    public function finalizePayment(int $commandeId, string $modePaiement): bool
    {
        return $this->update($commandeId, [
            'type_paiement' => $modePaiement,
            'statut'        => 'validee',
            // On pourrait ajouter ici 'date_paiement' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Crée une commande complète à partir du panier en une seule transaction.
     * Gère : Calcul total, Insertion Commande, Insertion Lignes, Baisse Stock.
     */
    public function createOrderFromCart(int $userId, array $panierItems): int
    {
        $db = \Config\Database::connect();
        $productModel = new \App\Models\ProductModel();
        
        // On lance la transaction
        $db->transStart();

        try {
            $total = 0;
            $lignesAInserer = [];

            // 1. Préparation des données et Calcul du total sécurisé (Prix BDD)
            foreach ($panierItems as $idProduit => $qty) {
                $produit = $productModel->find($idProduit);
                
                if (!$produit) continue;

                // Vérification ultime du stock (Sécurité transactionnelle)
                if ($produit->stock < $qty) {
                    // On lance une exception qui annulera la transaction
                    throw new \Exception("Stock insuffisant pour : " . $produit->nom);
                }

                $prix = $produit->prix;
                $total += $prix * $qty;

                $lignesAInserer[] = [
                    'product_id'    => $idProduit,
                    'quantite'      => $qty,
                    'prix_unitaire' => $prix,
                    // 'total_ligne' => $prix * $qty // Si ta table a cette colonne
                ];
            }

            // 2. Insertion de la commande
            $dataCommande = [
                'id_user'       => $userId,
                'total'         => $total,
                'statut'        => 'attente', // En attente de paiement
                'date_creation' => date('Y-m-d H:i:s')
            ];

            // On insère et on récupère l'ID
            $this->insert($dataCommande); 
            $commandeId = $this->insertID();

            // 3. Insertion des lignes et Mise à jour des stocks
            $lignesModel = new \App\Models\LignesCommandeModel();
            
            foreach ($lignesAInserer as $ligne) {
                // Lien avec la commande créée
                $ligne['commande_id'] = $commandeId;
                
                // Insertion ligne
                $lignesModel->insert($ligne);

                // Décrémentation Stock
                // Note : On utilise le Query Builder ici pour être atomique
                $db->table('produits')
                   ->where('id', $ligne['product_id'])
                   ->decrement('stock', $ligne['quantite']);
            }

            // Si tout est bon, on valide la transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Erreur lors de la transaction SQL.");
            }

            return $commandeId;

        } catch (\Exception $e) {
            // En cas d'erreur, tout est annulé (Rollback automatique via transStart/Complete ou manuel)
            // CodeIgniter transComplete gère le rollback si status est false, 
            // mais l'exception permet de remonter le message au controller.
            throw $e;
        }
    }

    public function createOrderViaStoredProc($userId, $total) {
        $db = \Config\Database::connect();
        // Appel de la procédure
        $db->query("CALL sp_creer_commande(?, ?, @id)", [$userId, $total]);
        // Récupération de l'ID de sortie
        $result = $db->query("SELECT @id as id")->getRow();
        return $result->id;
    }

    // --- CONFIGURATIONS STANDARDS ---

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}