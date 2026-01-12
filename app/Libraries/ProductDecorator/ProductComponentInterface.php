<?php
namespace App\Libraries\ProductDecorator;

interface ProductComponentInterface {
    public function getPrice(): float;
    public function getHtmlDisplay(): string; // Pour afficher le prix formaté
}