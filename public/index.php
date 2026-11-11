<?php

require __DIR__ . '/../src/Core/Router.php';
require __DIR__ . '/../src/Core/View.php';
require __DIR__ . '/../src/Model/Product.php';          // НОВОЕ
require __DIR__ . '/../src/Controller/HomeController.php';
require __DIR__ . '/../src/Controller/CatalogController.php'; // НОВОЕ

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
    '/'        => [HomeController::class, 'index'],
    '/catalog' => [CatalogController::class, 'index'], // НОВОЕ
];

$router = new Router($routes);
$router->dispatch($uri);