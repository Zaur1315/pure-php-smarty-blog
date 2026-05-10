<?php
declare(strict_types=1);

use App\Controller\CategoryController;
use App\Controller\HomeController;
use App\Controller\PostController;
use App\Core\Router\Router;

return static function (Router $router): void {
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/category/{slug}', [CategoryController::class, 'show']);
    $router->get('/post/{slug}', [PostController::class, 'show']);
};
