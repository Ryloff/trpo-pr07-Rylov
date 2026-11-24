<?php
// 1. ЗАПУСК СЕССИИ И CSRF (в самом начале)
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

// 2. АВТОЗАГРУЗКА КЛАССОВ (до того, как мы их используем)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $file = $base_dir . str_replace('\\', '/', substr($class, $len)) . '.php';
    if (file_exists($file)) require_once $file;
});

// 3. ПОДКЛЮЧЕНИЕ ЯДРА (Router и View, они без namespace)
require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Core/View.php';

// 4. ИСПОЛЬЗОВАНИЕ КЛАССОВ (use)
use App\Controller\HomeController;
use App\Controller\CatalogController;
use App\Controller\CartController;
use App\Controller\CheckoutController; // <--- ВОТ ОН
use App\Controller\ErrorController;
use App\Repositories\ProductRepository;
use App\Services\CartService;

// 5. ИНИЦИАЛИЗАЦИЯ ЗАВИСИМОСТЕЙ (создаем объекты)
$productRepo = new ProductRepository(__DIR__ . '/../data/products.json');
$cartService = new CartService();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// --- ОБРАБОТКА POST-ЗАПРОСОВ (Корзина и Checkout) ---
if ($method === 'POST') {
    if ($uri === '/cart/add' || $uri === '/cart/remove' || $uri === '/cart/update') {
        $controller = new CartController($cartService, $productRepo);
        if ($uri === '/cart/add') $controller->add();
        if ($uri === '/cart/remove') $controller->remove();
        if ($uri === '/cart/update') $controller->update();
        exit;
    }
    
    if ($uri === '/checkout') {
        $controller = new CheckoutController($cartService, $productRepo);
        $controller->process();
        exit;
    }
}

// --- ОБРАБОТКА GET-ЗАПРОСОВ (Корзина и Checkout) ---
if ($uri === '/cart') {
    $controller = new CartController($cartService, $productRepo);
    $controller->index();
    exit;
}

if ($uri === '/checkout') {
    $controller = new CheckoutController($cartService, $productRepo);
    $controller->index();
    exit;
}

if ($uri === '/checkout/success') {
    $controller = new CheckoutController($cartService, $productRepo);
    $controller->success();
    exit;
}

// Динамический маршрут карточки товара
if (preg_match('/^\/product\/(\d+)$/', $uri, $matches)) {
    $controller = new CatalogController($productRepo);
    $controller->show((int)$matches[1]);
    exit;
}

// --- СТАНДАРТНЫЕ GET МАРШРУТЫ (через Router) ---
$routes = [
    '/'        => [HomeController::class, 'index'],
    '/catalog' => [CatalogController::class, 'index'],
    '/about'   => [HomeController::class, 'about'],
    '/missing' => [ErrorController::class, 'notFound'],
];

$router = new Router($routes);
$router->dispatch($uri, $productRepo);