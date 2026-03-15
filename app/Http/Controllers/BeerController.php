<?php

namespace App\Http\Controllers;

use App\Models\Beer;
use App\Services\BeerService;
use Illuminate\Http\Request;
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

    public function create(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|min:3',
            'type'        => 'required|string|min:3',
            'is_homemade' => 'required|boolean',
            'volume'      => 'required_if:is_homemade,false|missing_if:is_homemade,true|decimal:0,2',
            'abv'         => 'required_if:is_homemade,false|missing_if:is_homemade,true|decimal:0,2',
        ]);

        return $this->jsonCreatedResponse(
            $this->beerService->create(
                $request->string('name'),
                $request->string('type'),
                $request->boolean('is_homemade'),
                $request->has('volume') ? $request->float('volume') : null,
                $request->has('abv') ? $request->float('abv') : null,
            ),
        );
    }
}
