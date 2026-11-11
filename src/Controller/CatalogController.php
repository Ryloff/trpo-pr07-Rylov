<?php

final class CatalogController
{
    public function index(): void
    {
        // Тестовый массив (в следующей работе заменим на данные из БД/JSON)
        $products = [
            new Product(1, 'Учебник по PHP', 1200.50),
            new Product(2, 'Тетрадь для конспектов', 150.00),
            new Product(3, 'Набор ручек', 450.00),
        ];

        $data = [
            'title'    => 'Каталог товаров',
            'products' => $products,
        ];

        View::render('catalog', $data);
    }
}