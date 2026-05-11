<?php

namespace App\Controller;

use App\Core\Http\Response;
use App\Core\View\View;
use App\Repository\CategoryRepository;
use Exception;

/**
 * Base controller for public pages.
 *
 * Contains shared rendering logic and automatically provides
 * navigation categories to every template.
 */
abstract readonly class BaseController
{
    public function __construct(
        protected View               $view = new View(),
        protected CategoryRepository $categoryRepository = new CategoryRepository(),
    ) {
    }

    /**
     * Renders a Smarty template with shared layout data.
     *
     * @param array<string, mixed> $data
     *
     * @throws Exception
     */
    protected function render(string $template, array $data = [], int $statusCode = 200): Response
    {
        return new Response(
            $this->view->render($template, array_merge([
                'navCategories' => $this->categoryRepository->findAll(),
            ], $data)),
            $statusCode
        );
    }

    /**
     * Renders a reusable 404 error page.
     *
     * @throws Exception
     */
    protected function notFound(string $message = 'The page you are looking for does not exist.'): Response
    {
        return $this->render('error/404.tpl', [
            'title' => '404',
            'message' => $message,
        ], 404);
    }
}