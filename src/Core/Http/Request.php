<?php
declare(strict_types=1);

namespace App\Core\Http;

/**
 * Represents the current HTTP request.
 *
 * Wraps request method, URI and query parameters
 * in a small immutable object.
 */
final readonly class Request
{
    public function __construct(
        private string $method,
        private string $uri,
        private array  $query = []
    )
    {
    }

    /**
     * Creates a request instance from PHP global variables.
     */
    public static function createFromGlobals(): self
    {
        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'] ?? '/',
            $_GET
        );
    }

    /**
     * Returns the HTTP method in uppercase format.
     */
    public function method(): string
    {
        return strtoupper($this->method);
    }

    /**
     * Returns only the path part of the request URI.
     */
    public function uri(): string
    {
        $path = parse_url($this->uri, PHP_URL_PATH);

        return $path === null ? '/' : $path;
    }

    /**
     * Returns a single query parameter by key.
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }
}