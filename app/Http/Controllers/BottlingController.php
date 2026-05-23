<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBottlingRequest;
use App\Services\BottlingService;
use Tests\Feature\Http\Controllers\BottlingControllerTest;

/**
 * @see BottlingControllerTest
 */
class BottlingController extends Controller
{

    public function __construct(private readonly BottlingService $bottlingService)
    {
    }

    public function list()
    {
        return $this->jsonResponse(
            $this->bottlingService->list(),
        );
    }

    public function create(CreateBottlingRequest $request)
    {
        $this->bottlingService->create(
            $request->integer('beer_id'),
            $request->array('bottle_ids'),
        );

        return $this->jsonCreatedResponse();
    }

    public function delete(int $bottlingId)
    {
        $this->bottlingService->delete($bottlingId);

        return $this->emptyResponse();
    }
}
