<?php

namespace App\Libraries\OrderChain\Handlers;

use App\Libraries\OrderChain\AbstractOrderHandler;
use App\Models\CommandesModel;
use App\Models\LignesCommandeModel;
use App\Models\ProductModel;

class OrderCreationHandler extends AbstractOrderHandler
{
    public function handle(array $context): array
    {
        $commandeModel = new CommandesModel();
        $lignesModel   = new LignesCommandeModel();
        $productModel  = new ProductModel();

        // 1. Calcul du total
        $total = 0;
        foreach ($context['panier'] as $idProduit => $qty) {
            $p = $productModel->find($idProduit);
            $total += $p->prix * $qty;
        }

        // 2. Création Commande
        $commandeId = $commandeModel->insert([
            'id_user'       => $context['userId'],
            'total'         => $total,
            'statut'        => 'attente',
            'date_creation' => date('Y-m-d H:i:s')
        ]);

        // 3. Création Lignes
        foreach ($context['panier'] as $idProduit => $qty) {
            $p = $productModel->find($idProduit);
            $lignesModel->insert([
                'commande_id'   => $commandeId,
                'product_id'    => $idProduit,
                'quantite'      => $qty,
                'prix_unitaire' => $p->prix
            ]);
        }

        // On ajoute l'ID créé au contexte pour la suite
        $context['commandeId'] = $commandeId;

        return parent::handle($context);
    }
}