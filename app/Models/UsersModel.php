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
     * Initialise une nouvelle construction d'utilisateur
     */
    public function newUser(): self
    {
        $this->tempData = ['role' => 'client'];
        return $this;
    }

    public function withCredentials(string $login, string $password): self
    {
        $this->tempData['login'] = $login;
        $this->tempData['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function withIdentity(string $nom, string $prenom, string $email): self
    {
        $this->tempData['nom'] = $nom;
        $this->tempData['prenom'] = $prenom;
        $this->tempData['email'] = $email;
        return $this;
    }

    public function withRole(string $role): self
    {
        $this->tempData['role'] = $role;
        return $this;
    }

    /**
     * Finalise et sauvegarde en base de données
     */
    public function create(): bool
    {
        $result = $this->save($this->tempData);
        $this->tempData = [];
        return $result;
    }
}