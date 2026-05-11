<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Repository\PostRepository;

final readonly class PostController extends BaseController
{
    public function __construct(
        private PostRepository $postRepository = new PostRepository(),
    )
    {
        parent::__construct();
    }

    /**
     * @throws /Exception
     */
    public function show(Request $request, string $slug): Response
    {
        $post = $this->postRepository->findBySlug($slug);

        if ($post === null) {
            return $this->notFound('Post not found');
        }

        $this->postRepository->incrementViews((int)$post['id']);

        return $this->render('post/show.tpl', [
            'title' => $post['title'],
            'post' => $post,
            'relatedPosts' => $this->postRepository->findRelatedPosts((int)$post['id']),
        ]);
    }
}