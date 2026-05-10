<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use App\Core\Http\Request;
use App\Core\Router\Router;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$request = Request::createFromGlobals();
$router = new Router();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$routes = require __DIR__ . '/../config/routes.php';
$routes($router);

$response = $router->dispatch($request);
$response->send();
