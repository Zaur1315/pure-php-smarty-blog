<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\View\View;

final class HomeController
{
    public function index(): void
    {
        $view = new View();

        $view->render('home/index.tpl', [
            'title' => 'Home',
            'message' => 'Home Page',
        ]);
    }
}