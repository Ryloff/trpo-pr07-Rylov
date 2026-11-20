<?php

namespace App\Repositories;

use App\Model\Product;
use App\Model\Category;

class ProductRepository
{
    private array $products = [];
    private array $categories = [];

    // В конструктор передаем пути к файлам (п.5, п.6 задания)
    public function __construct(string $productsFile, string $categoriesFile)
    {
        // Читаем категории
        $catData = json_decode(file_get_contents($categoriesFile), true);
        foreach ($catData as $row) {
            $this->categories[$row['id']] = new Category($row['id'], $row['name']);
        }

        // Читаем товары
        $prodData = json_decode(file_get_contents($productsFile), true);
        foreach ($prodData as $row) {
            $this->products[] = new Product(
                $row['id'],
                $row['name'],
                (float)$row['price'],
                (int)$row['category_id'],
                (int)$row['stock']
            );
        }
    }

    // Получить все категории
    public function getAllCategories(): array
    {
        return $this->categories;
    }

    // Получить отфильтрованный и отсортированный список товаров (п.8, п.9)
    public function getFilteredProducts(?int $categoryId = null, string $sort = 'name'): array
    {
        $result = $this->products;

        // Фильтрация по категории
        if ($categoryId !== null) {
            $result = array_filter($result, fn($p) => $p->categoryId === $categoryId);
        }

        // Сортировка
        usort($result, function ($a, $b) use ($sort) {
            if ($sort === 'price') {
                return $a->price <=> $b->price;
            }
            return strcmp($a->name, $b->name);
        });

        return $result;
    }

    // Найти один товар по ID (п.7)
    public function findById(int $id): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->id === $id) {
                return $product;
            }
        }
        return null; // Если не нашли
    }
}