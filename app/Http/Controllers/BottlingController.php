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

    public function create(CreateBottlingRequest $request)
    {
        $this->bottlingService->create(
            $request->integer('beer_id'),
            $request->array('bottle_ids'),
        );

        return $this->jsonCreatedResponse();
    }
}
