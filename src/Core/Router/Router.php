<?php
declare(strict_types=1);

namespace App\Core\Router;

use App\Core\Http\Request;
use App\Core\Http\Response;

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

    public function dispatch(Request $request): Response
    {
        $action = $this->routes[$request->method()][$request->uri()] ?? null;

        if ($action === null) {
            return new Response('404 Not Found', 404);
        }

        if (is_callable($action)) {
            $response = call_user_func($action);

            return $response instanceof Response
                ? $response
                : new Response((string)$response);
        }

        [$controller, $controllerMethod] = $action;

        $controllerInstance = new $controller();

        $response = call_user_func([$controllerInstance, $controllerMethod]);

        return $response instanceof Response
            ? $response
            : new Response((string)$response);
    }
}