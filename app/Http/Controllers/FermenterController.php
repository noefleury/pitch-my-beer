<?php

namespace App\Http\Controllers;

use App\Models\Fermenter;
use App\Services\FermenterService;
use Illuminate\Http\Request;
use Tests\Feature\Http\Controllers\FermenterControllerTest;

/**
 * @see FermenterControllerTest
 */
class FermenterController extends Controller
{

    public function __construct(private readonly FermenterService $fermenterService)
    {
    }

    public function show(Fermenter $fermenter)
    {
        return $this->jsonResponse(
            $this->fermenterService->show($fermenter),
        );
    }

    public function getRelations(Fermenter $fermenter)
    {
        return $this->jsonResponse(
            $this->fermenterService->getRelationsData($fermenter),
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'volume' => 'required|decimal:0,2',
            'name'   => 'string|alpha_dash|min:3',
        ]);

        return $this->jsonCreatedResponse(
            $this->fermenterService->create(
                $request->integer('volume'),
                $request->string('name'),
            ),
        );
    }
}
