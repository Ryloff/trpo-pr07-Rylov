<?php

final class Product
{
    public function __construct(
        public int $id,
        public string $title,
        public float $price
    ) {
    }
}