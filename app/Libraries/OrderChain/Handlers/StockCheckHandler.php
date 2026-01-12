<?php

namespace App\Libraries\OrderChain\Handlers;

use App\Libraries\OrderChain\AbstractOrderHandler;
use App\Models\ProductModel;

class StockCheckHandler extends AbstractOrderHandler
{
    public function handle(array $context): array
    {
        $productModel = new ProductModel();
        
        foreach ($context['panier'] as $idProduit => $qty) {
            $produit = $productModel->find($idProduit);
            if (!$produit || $produit->stock < $qty) {
                throw new \Exception("Stock insuffisant pour le produit : " . ($produit->nom ?? 'Inconnu'));
            }
        }

        // Tout est bon, on passe au suivant
        return parent::handle($context);
    }
}