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
        $method = $request->method();
        $uri = $request->uri();

        foreach ($this->routes[$method] ?? [] as $routeUri => $action) {
            $params = $this->matchRoute($routeUri, $uri);

            if ($params === null) {
                continue;
            }

            return $this->callAction($action, $params);
        }

        return new Response('404 Not Found', 404);
    }

    private function matchRoute(string $routeUri, string $requestUri): ?array
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)}#', '(?P<$1>[^/]+)', $routeUri);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $requestUri, $matches)) {
            return null;
        }

        return array_filter(
            $matches,
            static fn(string|int $key): bool => is_string($key),
            ARRAY_FILTER_USE_KEY
        );
    }

    private function callAction(callable|array $action, array $params = []): Response
    {
        if (is_callable($action)) {
            $response = call_user_func_array($action, $params);

            return $response instanceof Response
                ? $response
                : new Response((string) $response);
        }

        [$controller, $controllerMethod] = $action;

        $controllerInstance = new $controller();

        $response = call_user_func_array(
            [$controllerInstance, $controllerMethod],
            $params
        );

        return $response instanceof Response
            ? $response
            : new Response((string) $response);
    }
}
