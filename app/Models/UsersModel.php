<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Users;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $returnType       = Users::class;
    protected $allowedFields    = ['login','password','role','nom','prenom','email','adresse'];

    // Propriété temporaire pour stocker les données en cours de construction
    protected $tempData = [];

    /**
     * Récupère un utilisateur pour l'authentification
     * (Permet d'abstraire la logique de recherche du controller)
     */
    public function getUserByLogin(string $login)
    {
        return $this->where('login', $login)->first();
    }

    // --- INTERFACE FLUIDE (BUILDER) ---

    public function newUser(): self
    {
        $this->tempData = ['role' => 'client']; // Valeur par défaut
        return $this;
    }

    public function withCredentials(string $login, string $password): self
    {
        $this->tempData['login'] = $login;
        // Hashage immédiat
        $this->tempData['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function withIdentity(string $nom, string $prenom, string $email): self
    {
        $this->tempData['nom']    = $nom;
        $this->tempData['prenom'] = $prenom;
        $this->tempData['email']  = $email;
        return $this;
    }

    public function withRole(string $role): self
    {
        $this->tempData['role'] = $role;
        return $this;
    }

    /**
     * Finalise et sauvegarde
     */
    public function create(): bool
    {
        // On sauvegarde les données accumulées
        // Note: insert() est souvent préférable à save() pour une création pure
        $result = $this->insert($this->tempData);
        
        // Nettoyage après insertion
        $this->tempData = [];
        
        // insert renvoie l'ID (int) ou false. On cast en bool.
        return ($result !== false);
    }

    /**
     * Règles de validation pour la mise à jour du profil
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
}