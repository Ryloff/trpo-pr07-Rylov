<?php

// 1. Подключаем классы вручную (автозагрузки нет — так проще)
require __DIR__ . '/../src/Core/Router.php';
require __DIR__ . '/../src/Core/View.php';
require __DIR__ . '/../src/Controller/HomeController.php';
// 2. Берём путь из URL, отрезаем GET-параметры
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 3. Таблица маршрутов: путь => что вызвать
//    Пока контроллеров нет, используем замыкания (функции)
$routes = [
    '/' => [HomeController::class, 'index'],
];

// 4. Создаём Router и запускаем
$router = new Router($routes);
$router->dispatch($uri);