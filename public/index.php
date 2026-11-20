<?php

// 1. Простая автозагрузка классов (вместо require)
spl_autoload_register(function ($class) {
    // Префикс наших классов
    $prefix = 'App\\';
    // Базовая директория, где лежат папки Models, Controllers, Repositories
    $base_dir = __DIR__ . '/../src/';

    // Если класс не начинается с App\, пропускаем
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Отрезаем App\ от имени класса (получаем Repositories\ProductRepository)
    $relative_class = substr($class, $len);

    // Собираем путь: src/Repositories/ProductRepository.php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Если файл существует — подключаем
    if (file_exists($file)) {
        require_once $file;
    }
});

// 2. Подключаем классы ядра (они не в namespace)
require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Core/View.php';

use App\Controller\HomeController;
use App\Controller\CatalogController;
use App\Controller\ErrorController;
use App\Repositories\ProductRepository;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Создаем репозиторий (он нам понадобится для каталога)
$productRepo = new ProductRepository(__DIR__ . '/../data/products.json', __DIR__ . '/../data/categories.json');

// 3. Обработка динамического маршрута /product/{id}
// Если URL начинается с /product/ и содержит цифры
if (preg_match('/^\/product\/(\d+)$/', $uri, $matches)) {
    $id = (int)$matches[1];
    $controller = new CatalogController($productRepo);
    $controller->show($id);
    exit;
}

// 4. Стандартная таблица маршрутов
$routes = [
    '/'        => [HomeController::class, 'index'],
    '/catalog' => [CatalogController::class, 'index'],
    '/about'   => [HomeController::class, 'about'],
    '/missing' => [ErrorController::class, 'notFound'],
];

$router = new Router($routes);
$router->dispatch($uri, $productRepo); // Передаем репозиторий в роутер (для контроллера каталога)