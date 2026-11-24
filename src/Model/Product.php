<?php
namespace App\Model;

class Product
{
    public function __construct(
        public int $id,
        public string $name,
        public float $price
    ) {}

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }
}