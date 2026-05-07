<?php
declare(strict_types=1);

namespace App\Core\Http;

final readonly class Request
{
    public function __construct(
        private string $method,
        private string $uri
    ) {
    }

    public static function createFromGlobals(): self
    {
        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'] ?? '/'
        );
    }

    public function method(): string
    {
        return strtoupper($this->method);
    }

    public function uri(): string
    {
        return strtok($this->uri, '?') ?: '/';
    }

}