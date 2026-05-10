<?php
declare(strict_types=1);

namespace App\Core\Http;

final readonly class Request
{
    public function __construct(
        private string $method,
        private string $uri,
        private array  $query = []
    )
    {
    }

    public static function createFromGlobals(): self
    {
        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'] ?? '/',
            $_GET
        );
    }

    public function method(): string
    {
        return strtoupper($this->method);
    }

    public function uri(): string
    {
        $path = parse_url($this->uri, PHP_URL_PATH);

        return $path === null ? '/' : $path;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    public function queryParam(): array
    {
        return $this->query;
    }

}