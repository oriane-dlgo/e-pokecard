<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // 1. Est-ce qu'il est connecté ?
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('msg', 'Accès réservé au personnel de la Ligue.');
        }

        // 2. Est-ce qu'il est ADMIN ?
        // (Assure-toi que dans ta BDD, ton user admin a bien le role 'admin')
        if ($session->get('user_role') !== 'admin') {
            return redirect()->to('/')->with('msg', 'ACCÈS REFUSÉ : VOUS N\'ÊTES PAS ADMINISTRATEUR.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien à faire après
    }
}