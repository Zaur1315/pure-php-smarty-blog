<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Repository\PostRepository;

final readonly class CategoryController extends BaseController
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_SORT = 'published_at';
    private const DEFAULT_DIRECTION = 'desc';
    private const PER_PAGE = 6;

    public function __construct(
        private PostRepository $postRepository = new PostRepository(),
    )
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function show(Request $request, string $slug): Response
    {
        $category = $this->categoryRepository->findBySlug($slug);

        if ($category === null) {
            return $this->notFound('Category not found');
        }

        $page = max((int) $request->query('page', self::DEFAULT_PAGE), self::DEFAULT_PAGE);
        $sort = (string) $request->query('sort', self::DEFAULT_SORT);
        $direction = (string) $request->query('direction', self::DEFAULT_DIRECTION);

        $totalPosts = $this->postRepository->countByCategorySlug($slug);
        $totalPages = (int) ceil($totalPosts / self::PER_PAGE);
        $offset = ($page - 1) * self::PER_PAGE;

        return $this->render('category/show.tpl', [
            'title' => $category['name'],
            'category' => $category,
            'posts' => $this->postRepository->findByCategorySlugPaginated(
                $slug,
                self::PER_PAGE,
                $offset,
                $sort,
                $direction
            ),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }
}