<?php

namespace App\Controller;

use App\Repositories\ProductRepository;
use \View; // Если View не в namespace, подключаем так

class CatalogController
{
    // Внедряем зависимость через конструктор (п.6)
    public function __construct(private ProductRepository $repo)
    {
    }

    // Главная страница каталога с фильтрами
    public function index(): void
    {
        // Берем данные из GET-запроса
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $sort = $_GET['sort'] ?? 'name'; // по умолчанию сортируем по имени

        // Получаем данные из репозитория
        $products = $this->repo->getFilteredProducts($categoryId, $sort);
        $categories = $this->repo->getAllCategories();

        View::render('catalog', [
            'title' => 'Каталог товаров',
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $categoryId,
            'currentSort' => $sort
        ]);
    }

    // Страница одного товара
    public function show(int $id): void
    {
        $product = $this->repo->findById($id);

        // Если товара нет — отдаем 404 (п.7)
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