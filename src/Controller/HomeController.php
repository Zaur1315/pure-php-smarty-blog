<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Response;
use App\Repository\PostRepository;

final readonly class HomeController extends BaseController
{
    public function __construct(
        private readonly PostRepository $postRepository = new PostRepository(),
    ) {
        parent::__construct();
    }

    /**
     * @throws /Exception
     */
    public function index(): Response
    {
        return $this->render('home/index.tpl', [
            'title' => 'Home',
            'categories' => $this->categoryRepository->findWithLatestPosts(),
            'sliderPosts' => $this->postRepository->findLeastViewedPostsByCategories(),
        ]);
    }
}