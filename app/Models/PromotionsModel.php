<?php


namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Produit;

class PromotionsModel extends Model
{
    protected $table            = 'promotions';
    protected $primaryKey       = 'idPromo';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\Promotions';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'tauxPromo',
        'dateDebut',
        'dateFin'
    ];

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