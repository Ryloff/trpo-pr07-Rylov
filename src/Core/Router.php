<?php

final class Router
{
    // Таблица маршрутов: путь => функция
    private array $routes;

    // Конструктор принимает маршруты
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    // Находит маршрут по URL и вызывает его
    public function dispatch(string $uri): void
    {
        if (array_key_exists($uri, $this->routes)) {
            $action = $this->routes[$uri];
            $action();
            return;
        }

        // Маршрут не найден — отдаём 404
        http_response_code(404);
        echo '<h1>404 — страница не найдена</h1>';
    }
}