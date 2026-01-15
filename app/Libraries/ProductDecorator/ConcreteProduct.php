<?php
namespace App\Libraries\ProductDecorator;

class ConcreteProduct implements ProductComponentInterface {
    protected $product;

    public function __construct($product) {
        $this->product = $product;
    }

    public function getPrice(): float {
        return $this->product->prix;
    }

    // C'est ici qu'on définit le HTML "Standard" (sans promo)
    public function getHtmlDisplay(): string {
        return '<span class="prix-final">' . number_format($this->product->prix, 2) . '€</span>';
    }
}