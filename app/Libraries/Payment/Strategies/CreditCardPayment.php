<?php

namespace App\Libraries\Payment\Strategies;

use App\Libraries\Payment\PaymentStrategyInterface;
use App\Models\CommandesModel;

class CreditCardPayment implements PaymentStrategyInterface
{
    public function pay(int $commandeId): void
    {
        // Simulation de l'appel API Stripe/Banque ici...
        
        // Mise à jour via le modèle
        $model = new CommandesModel();
        $model->finalizePayment($commandeId, 'Carte Bancaire');
    }
}