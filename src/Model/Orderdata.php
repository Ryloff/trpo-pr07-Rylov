<?php
namespace App\Model;

class OrderData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $delivery,
        public float $total
    ) {}
}