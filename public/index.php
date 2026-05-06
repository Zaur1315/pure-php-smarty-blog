<?php

declare(strict_types=1);

use App\Core\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$routes = require __DIR__ . '/../config/routes.php';
$routes($router);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
);