<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Response;
use App\Core\View\View;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Smarty\Exception;

final class CategoryController
{
    /**
     * @throws Exception
     */
    public function show(string $slug): Response
    {
        $view = new View();

        $categoryRepository = new CategoryRepository();
        $postRepository = new PostRepository();

        $category = $categoryRepository->findBySlug($slug);

        if ($category === null) {
            return new Response('Category not found', 404);
        }

        $posts = $postRepository->findByCategorySlug($slug);

        return new Response(
            $view->render('category/show.tpl', [
                'category' => $category,
                'posts' => $posts,
            ])
        );
    }
}
