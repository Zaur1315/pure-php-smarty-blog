<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Request;
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
    public function show(Request $request, string $slug): Response
    {
        $view = new View();

        $categoryRepository = new CategoryRepository();
        $postRepository = new PostRepository();

        $category = $categoryRepository->findBySlug($slug);

        if ($category === null) {
            return new Response('Category not found', 404);
        }

        $page = max(1, (int)$request->query('page', 1));
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $sort = (string)$request->query('sort', 'published_at');
        $direction = (string)$request->query('direction', 'DESC');

        $total = $postRepository->countByCategorySlug($slug);
        $pages = (int)ceil($total / $limit);

        $posts = $postRepository->findByCategorySlugPaginated(
            $slug,
            $limit,
            $offset,
            $sort,
            $direction
        );

        return new Response(
            $view->render('category/show.tpl', [
                'category' => $category,
                'posts' => $posts,
                'pagination' => [
                    'page' => $page,
                    'pages' => $pages,
                    'total' => $total,
                    'limit' => $limit,
                ],
                'sorting' => [
                    'sort' => $sort,
                    'direction' => strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC',
                ],
            ])
        );
    }
}