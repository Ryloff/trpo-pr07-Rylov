<?php

namespace App\Controller;

use App\Repositories\ProductRepository;
use \View;

class CatalogController
{
    // Внедряем зависимость через конструктор
    public function __construct(private ProductRepository $repo)
    {
    }

    // Главная страница каталога
    public function index(): void
    {
        // В новом JSON нет категорий, поэтому просто получаем все товары
        $products = $this->repo->getAll();

        View::render('catalog', [
            'title' => 'Каталог товаров',
            'products' => $products
        ]);
    }

    // Страница одного товара
    public function show(int $id): void
    {
        $product = $this->repo->findById($id);

        // Если товара нет — отдаем 404
        if ($product === null) {
            http_response_code(404);
            View::render('404', ['title' => 'Товар не найден']);
            return;
        }

        View::render('product', [
            'title' => $product->name,
            'product' => $product
        ]);
    }
}