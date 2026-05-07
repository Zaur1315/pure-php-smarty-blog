<?php
declare(strict_types=1);

namespace App\Core\Http;

final readonly class Response
{
    public function __construct(
        private string $content = '',
        private int    $statusCode = 200,
        private array  $headers = []
    )
    {
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $this->content;
    }
}