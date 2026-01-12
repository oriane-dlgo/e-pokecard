<?php
namespace App\Libraries\ProductDecorator;

abstract class ProductDecorator implements ProductComponentInterface {
    protected $wrappedProduct;

    public function __construct(ProductComponentInterface $product) {
        $this->wrappedProduct = $product;
    }

    public function getPrice(): float {
        return $this->wrappedProduct->getPrice();
    }

    public function getHtmlDisplay(): string {
        return $this->wrappedProduct->getHtmlDisplay();
    }
}