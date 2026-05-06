<?php
declare(strict_types=1);

namespace App\Core\Router;

final class Router
{
    private array $routes = [];

    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute(string $method, string $uri, callable|array $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = strtok($uri, '?');

        $action = $this->routes[$method][$uri] ?? null;

        if ($action === null) {
            http_response_code(404);

            echo '404 Not Found';

            return;
        }

        if (is_callable($action)) {
            call_user_func($action);

            return;
        }

        [$controller, $controllerMethod] = $action;

        $controllerInstance = new $controller();

        call_user_func([$controllerInstance, $controllerMethod]);
    }
}