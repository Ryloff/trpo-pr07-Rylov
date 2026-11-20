<?php

final class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    // Добавили $repo как зависимость
    public function dispatch(string $uri, $repo = null): void
    {
        if (!array_key_exists($uri, $this->routes)) {
            http_response_code(404);
            View::render('404', ['title' => '404 — Не найдено']);
            return;
        }

        $action = $this->routes[$uri];

        if (is_array($action)) {
            $controllerClass = $action[0];
            $method = $action[1];

            // Если это CatalogController, передаем ему репозиторий
            if ($controllerClass === 'App\Controller\CatalogController') {
                $controller = new $controllerClass($repo);
            } else {
                $controller = new $controllerClass();
            }
            
            $controller->$method();
            return;
        }

        $action();
    }
}