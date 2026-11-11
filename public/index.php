<?php

// 1. Подключаем классы вручную (автозагрузки нет — так проще)
require __DIR__ . '/../src/Core/Router.php';
require __DIR__ . '/../src/Core/View.php';

// 2. Берём путь из URL, отрезаем GET-параметры
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 3. Таблица маршрутов: путь => что вызвать
//    Пока контроллеров нет, используем замыкания (функции)
$routes = [
    '/'        => function () {
        echo '<h1>Главная страница</h1>';
    },
    '/catalog' => function () {
        echo '<h1>Каталог</h1>';
    },
    // Временный маршрут, чтобы проверить View::render
    '/test'    => function () {
        View::render('test', ['message' => 'Render работает']);
    },
];

// 4. Создаём Router и запускаем
$router = new Router($routes);
$router->dispatch($uri);