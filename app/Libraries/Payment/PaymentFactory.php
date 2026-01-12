<?php

namespace App\Libraries\Payment;

use App\Libraries\Payment\Strategies\CreditCardPayment;
use App\Libraries\Payment\Strategies\PayPalPayment;

class PaymentFactory
{
    public static function create(string $type): PaymentStrategyInterface
    {
        return match(strtolower($type)) {
            'card'   => new CreditCardPayment(),
            'paypal' => new PayPalPayment(),
            default  => throw new \Exception("Mode de paiement inconnu : " . $type),
        };
    }
}