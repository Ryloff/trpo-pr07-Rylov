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
        // Маршрут не найден — отдаём 404
        if (!array_key_exists($uri, $this->routes)) {
            http_response_code(404);
            View::render('404', ['title' => '404 — Не найдено']);
            return;
        }

        $action = $this->routes[$uri];

        if (is_array($action)) {
            $controllerClass = $action[0];
            $method = $action[1];

            $controller = new $controllerClass();
            $controller->$method();
            return;
        }

        $action();
    }
}