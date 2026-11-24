<?php
// 1. Запуск сессии (п.3)
session_start();

// Автозагрузка
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $file = $base_dir . str_replace('\\', '/', substr($class, $len)) . '.php';
    if (file_exists($file)) require_once $file;
});

require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Core/View.php';

use App\Controller\HomeController;
use App\Controller\CatalogController;
use App\Controller\ErrorController;
use App\Controller\CartController;
use App\Repositories\ProductRepository;
use App\Services\CartService;

// Инициализация
$productRepo = new ProductRepository(__DIR__ . '/../data/products.json');
$cartService = new CartService();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// --- ОБРАБОТКА POST-ЗАПРОСОВ (Действия корзины) ---
if ($method === 'POST') {
    $cartController = new CartController($cartService, $productRepo);
    
    if ($uri === '/cart/add') {
        $cartController->add();
    } elseif ($uri === '/cart/remove') {
        $cartController->remove();
    } elseif ($uri === '/cart/update') {
        $cartController->update();
    }
    exit;
}

// --- ОБРАБОТКА GET-ЗАПРОСОВ ---
if (preg_match('/^\/product\/(\d+)$/', $uri, $matches)) {
    $id = (int)$matches[1];
    $controller = new CatalogController($productRepo);
    $controller->show($id);
    exit;
}

if ($uri === '/cart') {
    $controller = new CartController($cartService, $productRepo);
    $controller->index();
    exit;
}

// Стандартные GET маршруты
$routes = [
    '/'        => [HomeController::class, 'index'],
    '/catalog' => [CatalogController::class, 'index'],
    '/about'   => [HomeController::class, 'about'],
    '/missing' => [ErrorController::class, 'notFound'],
];

$router = new Router($routes);
$router->dispatch($uri, $productRepo);