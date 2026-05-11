<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;

/**
 * Handles all unmatched routes.
 *
 * Used by the router as a fallback controller for 404 pages.
 */
final readonly class NotFoundController extends BaseController
{
    /**
     * Displays the default 404 page.
     *
     * @throws /Exception
     */
    public function __invoke(Request $request): Response
    {
        return $this->notFound();
    }
}