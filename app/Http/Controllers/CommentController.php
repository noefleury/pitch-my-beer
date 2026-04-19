<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Tests\Feature\Http\Controllers\CommentControllerTest;

/**
 * @see CommentControllerTest
 */
class CommentController extends Controller
{

    public function __construct(private readonly CommentService $commentService)
    {
    }

    // todo handle pagination
    public function list()
    {
        return $this->jsonResponse(
            $this->commentService->list(),
        );
    }

}
