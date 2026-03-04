<?php

namespace App\Http\Controllers;

use App\Models\Beer;
use App\Services\BeerService;
use Tests\Feature\Http\Controllers\BeerControllerTest;

/**
 * @see BeerControllerTest
 */
class BeerController extends Controller
{

    public function __construct(private readonly BeerService $beerService)
    {
    }

    public function list()
    {
        return $this->jsonResponse(
            $this->beerService->list(),
        );
    }

    public function get(Beer $beer)
    {
        return $this->jsonResponse(
            $this->beerService->get($beer),
        );
    }

    public function getRelations(Beer $beer)
    {
        return $this->jsonResponse(
            $this->beerService->getRelationsData($beer),
        );
    }
}
