<?php

namespace App\Libraries\OrderChain;

abstract class AbstractOrderHandler implements OrderHandlerInterface
{
    private ?OrderHandlerInterface $nextHandler = null;

    public function setNext(OrderHandlerInterface $handler): OrderHandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(array $context): array
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($context);
        }
        return $context; // Fin de la chaîne, on retourne le contexte enrichi (ex: avec l'ID commande)
    }
}