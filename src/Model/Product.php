<?php

namespace App\Model;

class Product
{
    public function __construct(
        public int $id,
        public string $name,
        public float $price,
        public int $categoryId,
        public int $stock // Дополнительное свойство из JSON
    ) {}

    // Метод для красивого вывода цены (п.11 задания)
    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }
}