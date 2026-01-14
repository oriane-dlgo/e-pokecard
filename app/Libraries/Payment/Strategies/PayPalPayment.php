<?php

namespace App\Libraries\Payment\Strategies;

use App\Libraries\Payment\PaymentStrategyInterface;
use App\Models\CommandesModel;

class PayPalPayment implements PaymentStrategyInterface
{
    public function pay(int $commandeId): void
    {
        // Simulation de l'appel API PayPal ici...
        
        // Mise à jour via le modèle
        $model = new CommandesModel();
        $model->finalizePayment($commandeId, 'PayPal');
    }
}