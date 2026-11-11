<?php

final class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(string $uri): void
    {
        // Если маршрута нет — 404
        if (!array_key_exists($uri, $this->routes)) {
            http_response_code(404);
            echo '<h1>404 — страница не найдена</h1>';
            return;
        }

        // Получаем то, что лежит в маршруте (массив или функцию)
        $action = $this->routes[$uri];

        // ЕСЛИ ЭТО МАССИВ (наш случай [HomeController::class, 'index'])
        if (is_array($action)) {
            // Достаём имя класса и имя метода
            $controllerClass = $action[0];
            $method = $action[1];

            // ВОТ ГЛАВНОЕ ИСПРАВЛЕНИЕ: создаём объект!
            $controller = new $controllerClass();
            
            // И вызываем метод уже у объекта, а не у класса
            $controller->$method();
            
            return;
        }

        // Если это обычная функция (замыкание) — вызываем её
        $action();
    }
}