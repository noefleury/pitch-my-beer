<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKeggingRequest;
use App\Services\KeggingService;
use Tests\Feature\Http\Controllers\KeggingControllerTest;

/**
 * @see KeggingControllerTest
 */
class KeggingController extends Controller
{

    public function __construct(private readonly KeggingService $keggingService)
    {
    }

    public function create(CreateKeggingRequest $request)
    {

        return $this->jsonCreatedResponse(
            $this->keggingService->create(
                $request->float('volume'),
                $request->integer('beer_id'),
                $request->integer('keg_id'),
            ),
        );
    }
}
