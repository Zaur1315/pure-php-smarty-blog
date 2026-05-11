<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;
use Smarty\Exception;

final readonly class NotFoundController extends BaseController
{
    /**
     * @throws /Exception
     */
    public function __invoke(Request $request): Response
    {
        return $this->notFound();
    }
}