<?php
namespace App\Libraries\ProductDecorator;

class PromoDecorator extends ProductDecorator {
    protected $tauxPromo;

    public function __construct(ProductComponentInterface $product, float $taux) {
        parent::__construct($product);
        $this->tauxPromo = $taux;
    }

    public function getPrice(): float {
        return $this->wrappedProduct->getPrice() * (1 - $this->tauxPromo);
    }

    // C'est ici qu'on définit le HTML "Spécial Promo"
    public function getHtmlDisplay(): string {
        $oldPrice = $this->wrappedProduct->getPrice();
        $newPrice = $this->getPrice();

        // Correspond exactement à ton 'if ($hasPromo)'
        return '<span class="zoom-text">' .
               '    <span class="prix-final">' . number_format($newPrice, 2) . '€</span>' .
               '    <span class="prix-sup">' . number_format($oldPrice, 2) . '€</span>' .
               '</span>';
    }
}