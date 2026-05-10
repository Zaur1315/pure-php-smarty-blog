<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View\View;
use App\Repository\PostRepository;
use Smarty\Exception;

final class PostController
{
    /**
     * @throws Exception
     */
    public function show(Request $request, string $slug): Response
    {
        $view = new View();
        $postRepository = new PostRepository();

        $post = $postRepository->findBySlug($slug);

        if ($post === null) {
            return new Response('Post not found', 404);
        }

        $postRepository->incrementViews((int)$post['id']);

        $post = $postRepository->findBySlug($slug);

        $relatedPosts = $postRepository->findRelatedPosts((int)$post['id']);

        return new Response(
            $view->render('post/show.tpl', [
                'post' => $post,
                'relatedPosts' => $relatedPosts,
            ])
        );
    }
}