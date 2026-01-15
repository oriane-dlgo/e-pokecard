<?php

namespace App\Libraries\OrderChain;

interface OrderHandlerInterface
{
    public function setNext(OrderHandlerInterface $handler): OrderHandlerInterface;
    public function handle(array $context): array;
}