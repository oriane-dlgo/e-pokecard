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