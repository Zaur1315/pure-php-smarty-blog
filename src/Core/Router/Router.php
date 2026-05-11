<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Controller\NotFoundController;
use App\Core\Http\Request;
use App\Core\Http\Response;

/**
 * Simple application router.
 *
 * Registers routes, matches incoming requests,
 * extracts route parameters and calls controllers/actions.
 */
final class Router
{
    /**
     * Registered application routes grouped by HTTP method.
     *
     * @var array<string, array<string, callable|array>>
     */
    private array $routes = [];

    /**
     * Registers a GET route.
     */
    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Registers a POST route.
     */
    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Stores a route definition.
     */
    private function addRoute(string $method, string $uri, callable|array $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    /**
     * Resolves the current request and executes the matched action.
     *
     * Falls back to NotFoundController when no route matches.
     */
    public function dispatch(Request $request): Response
    {
        $method = $request->method();
        $uri = $request->uri();

        foreach ($this->routes[$method] ?? [] as $routeUri => $action) {
            $params = $this->matchRoute($routeUri, $uri);

            if ($params === null) {
                continue;
            }

            return $this->callAction($action, $request, $params);
        }

        return $this->callAction([NotFoundController::class, '__invoke'], $request);
    }

    /**
     * Matches a request URI against a route pattern.
     *
     * Example:
     * /post/{slug}
     */
    private function matchRoute(string $routeUri, string $requestUri): ?array
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)}#', '(?P<$1>[^/]+)', $routeUri);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $requestUri, $matches)) {
            return null;
        }

        /**
         * Keeps only named route parameters.
         */
        return array_filter(
            $matches,
            static fn(string|int $key): bool => is_string($key),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Executes a controller action or callable route handler.
     */
    private function callAction(callable|array $action, Request $request, array $params = []): Response
    {
        /**
         * Route params are converted to positional arguments
         * to avoid named parameter conflicts in PHP 8+.
         */
        $arguments = array_merge([$request], array_values($params));

        if (is_callable($action)) {
            $response = call_user_func_array($action, $arguments);

            return $response instanceof Response
                ? $response
                : new Response((string)$response);
        }

        [$controller, $controllerMethod] = $action;

        $controllerInstance = new $controller();

        $response = call_user_func_array(
            [$controllerInstance, $controllerMethod],
            $arguments
        );

        return $response instanceof Response
            ? $response
            : new Response((string)$response);
    }
}
