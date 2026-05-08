<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Response;
use App\Core\View\View;
use App\Repository\CategoryRepository;
use Smarty\Exception;

final class HomeController
{
    /**
     * @throws Exception
     */
    public function index(): Response
    {
        $view = new View();
        $categoryRepository = new CategoryRepository();

        $categories = $categoryRepository->findWithLatestPosts();

        return new Response(
            $view->render('home/index.tpl', [
                'title' => 'Home',
                'categories' => $categories,
            ])
        );
    }
}
