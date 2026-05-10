<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Response;

final readonly class HomeController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function index(): Response
    {
        return $this->render('home/index.tpl', [
            'title' => 'Home',
            'categories' => $this->categoryRepository->findWithLatestPosts(),
        ]);
    }
}