<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromotionsModel;

class AdminPromotions extends BaseController
{
    public function index()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new PromotionsModel();

        // Récupération des filtres
        $statut = $this->request->getVar('statut');
        $q = $this->request->getVar('q');
        
        // Application des filtres
        $now = date('Y-m-d');

        if (!empty($q)) {
            $model->like('idPromo', $q);
        }

        if ($statut === 'active') {
            $model->where('dateDebut <=', $now)
                  ->where('dateFin >=', $now);
        } elseif ($statut === 'future') {
            $model->where('dateDebut >', $now);
        } elseif ($statut === 'expired') {
            $model->where('dateFin <', $now);
        }
        
        // On récupère tout, trié par date de fin (les plus récentes en premier)
        $data['promotions'] = $model->orderBy('dateFin', 'DESC')->paginate(10);
        $data['pager'] = $model->pager;
        $data['filters'] = ['statut' => $statut, 'q' => $q];

        return view('admin/Promotions/index', $data);
    }

    public function ajouter()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }
        return view('admin/Promotions/creation');
    }

    public function save()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $taux = $this->request->getPost('tauxPromo');
        $debut = $this->request->getPost('dateDebut');
        $fin = $this->request->getPost('dateFin');

        // Validation basique
        if ($fin < $debut) {
            return redirect()->back()->withInput()->with('error', 'La date de fin ne peut pas être antérieure au début !');
        }

        $model = new PromotionsModel();
        $model->insert([
            'tauxPromo' => $taux / 100, // Conversion 20 -> 0.20
            'dateDebut' => $debut,
            'dateFin'   => $fin
        ]);

        return redirect()->to('/admin/promotions')->with('msg', 'PROMOTION CRÉÉE AVEC SUCCÈS.');
    }

    public function edit($id)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new PromotionsModel();
        $promo = $model->find($id);

        if (!$promo) return redirect()->to('/admin/promotions');

        return view('admin/Promotions/edit', ['p' => $promo]);
    }

    public function update()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $id = $this->request->getPost('idPromo');
        $taux = $this->request->getPost('tauxPromo');
        $debut = $this->request->getPost('dateDebut');
        $fin = $this->request->getPost('dateFin');

        if ($fin < $debut) {
            return redirect()->back()->withInput()->with('error', 'La date de fin est invalide.');
        }

        $model = new PromotionsModel();
        $model->update($id, [
            'tauxPromo' => $taux / 100,
            'dateDebut' => $debut,
            'dateFin'   => $fin
        ]);

        return redirect()->to('/admin/promotions')->with('msg', 'PROMOTION MISE À JOUR.');
    }

    public function delete($id)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }
        
        $model = new PromotionsModel();
        
        // Optionnel : Vérifier si des produits utilisent cette promo avant de supprimer
        // Mais pour l'instant, faisons simple :
        $model->delete($id);

        return redirect()->to('/admin/promotions')->with('msg', 'PROMOTION SUPPRIMÉE.');
    }
}