<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use App\Core\Http\Request;
use App\Core\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$request = Request::createFromGlobals();
$router = new Router();

$routes = require __DIR__ . '/../config/routes.php';
$routes($router);

$response = $router->dispatch($request);
$response->send();