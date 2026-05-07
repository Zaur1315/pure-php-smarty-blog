<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Response;
use App\Core\View\View;
use Smarty\Exception;

final class HomeController
{
    /**
     * @throws Exception
     */
    public function index(): Response
    {
        $view = new View();

        return new Response(
            $view->render('home/index.tpl', [
                'title' => 'Home',
                'message' => 'Welcome to your new application.'
            ])
        );
    }
}