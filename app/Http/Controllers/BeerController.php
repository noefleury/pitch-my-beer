<?php

namespace App\Http\Controllers;

use App\Enums\FermenterType;
use App\Http\Requests\CreateBeerRequest;
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

    public function create(CreateBeerRequest $request)
    {
        if ($request->boolean('is_homemade')) {
            $beer = $this->beerService->createHomemade(
                $request->string('name'),
                $request->string('type'),
                $request->float('volume'),
                $request->enum('fermenter_type', FermenterType::class),
                $request->integer('fermenter_id'),
                $request->float('og_gravity'),
            );
        } else {
            $beer = $this->beerService->createBought(
                $request->string('name'),
                $request->string('type'),
                $request->float('volume'),
                $request->float('abv'),
            );
        }

        return $this->jsonCreatedResponse(
            $beer->only(['id', 'uid']),
        );
    }
}
