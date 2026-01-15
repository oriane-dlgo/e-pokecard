<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Users;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Users::class; 
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['login', 'password', 'nom', 'prenom', 'email', 'adresse', 'cp', 'ville', 'role'];

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

    /*
    * 1. MÉTHODES DE VALIDATION 
    */

    /**
     * Retourne les règles pour l'inscription
     * Appelée par Inscription::register()
     */
    public function getRegisterRules()
    {
        return [
            'login'    => 'required|min_length[3]|is_unique[users.login]',
            'password' => 'required|min_length[6]',
            'verify_password' => 'required|matches[password]',
            'nom'      => 'required|min_length[2]',
            'prenom'   => 'required|min_length[2]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'cgu'      => 'required',
            'adresse'  => 'required|min_length[10]|'
        ];
    }

    /**
     * Retourne les règles pour la mise à jour du profil
     * Appelée par Profil::update()
     */
    public function getUpdateRules($userId)
    {
        return [
            'nom'     => 'required|min_length[2]',
            'prenom'  => 'required|min_length[2]',
            // L'email doit être unique, sauf pour l'utilisateur actuel (id != $userId)
            'email'   => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'adresse' => 'permit_empty|min_length[5]'
        ];
    }


    /*
    * 2. MÉTHODES MÉTIER & BUILDER
    */

    /**
     * Récupère un utilisateur par son login
     */
    public function getUserByLogin($login)
    {
        return $this->where('login', $login)->first();
    }

    // --- DESIGN PATTERN BUILDER (Pour Inscription.php) ---
    
    protected $tempUser = [];

    // Etape 1 : Initialise la construction 
    public function newUser()
    {
        $this->tempUser = [
            'role' => 'client' // Rôle par défaut
        ];
        return $this;
    }

    
    // Etape 2 : Ajoute les identifiants
    public function withCredentials($login, $password)
    {
        $this->tempUser['login'] = $login;
        // Hashage du mot de passe
        $this->tempUser['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    
    // Etape 3 : Ajoute l'identité
    public function withIdentity($nom, $prenom, $email, $adresse)
    {
        $this->tempUser['nom'] = $nom;
        $this->tempUser['prenom'] = $prenom;
        $this->tempUser['email'] = $email;
        $this->tempUser['adresse'] = $adresse;
        return $this;
    }

    
    // Etape 4 : Finalise et insère en base
    public function create()
    {
        if (empty($this->tempUser)) {
            return false;
        }
        return $this->insert($this->tempUser);
    }
}