<?php

namespace App\Http\Controllers;

use App\Models\GazTank;
use App\Services\GazTankService;
use Illuminate\Http\Request;
use Tests\Feature\Http\Controllers\GazTankControllerTest;

/**
 * @see GazTankControllerTest
 */
class GazTankController extends Controller
{

    public function __construct(private readonly GazTankService $gazTankService)
    {
    }

    public function show(GazTank $gazTank)
    {
        return $this->jsonResponse(
            $this->gazTankService->show($gazTank),
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'volume'      => 'required|decimal:0,2',
            'co2_percent' => 'required|integer|between:0,100',
            'name'        => 'nullable|alpha_dash|min:3',
        ]);

        return $this->jsonCreatedResponse(
            $this->gazTankService->create(
                $request->float('volume'),
                $request->integer('co2_percent'),
                $request->input('name'),
            ),
        );
    }

    public function delete(int $gazTankId)
    {
        $this->gazTankService->delete($gazTankId);

        return $this->emptyResponse();
    }
}
