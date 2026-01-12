<?php

namespace App\Libraries\Payment;

interface PaymentStrategyInterface
{
    public function pay(int $commandeId): void;
}