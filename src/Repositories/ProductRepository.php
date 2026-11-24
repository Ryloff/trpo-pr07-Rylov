<?php
namespace App\Repositories;

use App\Model\Product;

class ProductRepository
{
    private array $products = [];

    public function __construct(string $productsFile)
    {
        $prodData = json_decode(file_get_contents($productsFile), true);
        foreach ($prodData as $row) {
            $this->products[] = new Product(
                (int)$row['id'],
                $row['name'],
                (float)$row['price']
            );
        }
    }

    public function getAll(): array
    {
        return $this->products;
    }

    public function findById(int $id): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->id === $id) return $product;
        }
        return null;
    }
}