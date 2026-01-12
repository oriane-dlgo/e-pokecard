<?php

namespace App\Libraries\OrderChain\Handlers;

use App\Libraries\OrderChain\AbstractOrderHandler;
use Config\Database;

class StockUpdateHandler extends AbstractOrderHandler
{
    public function handle(array $context): array
    {
        $db = Database::connect();
        
        foreach ($context['panier'] as $idProduit => $qty) {
            $db->table('produits')
               ->where('id', $idProduit)
               ->decrement('stock', $qty);
        }

        return parent::handle($context);
    }
}