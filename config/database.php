<?php

declare(strict_types=1);

/**
 * Database connection configuration.
 *
 * Values are loaded from environment variables defined in .env.
 */
return [
    'host' => $_ENV['DB_HOST'],
    'port' => (int) $_ENV['DB_PORT'],
    'dbname' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
];
