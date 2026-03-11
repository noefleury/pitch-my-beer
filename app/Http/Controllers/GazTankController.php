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
            'co2_percent' => 'required_without:n2_percent|integer|between:0,100',
            'n2_percent'  => 'required_without:co2_percent|integer|between:0,100',
            'name'        => 'nullable|alpha_dash|min:3',
        ]);

        // handle gaz data as cannot be more than 100%
        // todo kick one from db as not useful
        $co2Percent = $request->filled('co2_percent')
            ? $request->integer('co2_percent')
            : 100 - $request->integer('n2_percent');

        $n2Percent = $request->filled('co2_percent')
            ? 100 - $co2Percent
            : $request->integer('n2_percent');

        return $this->jsonCreatedResponse(
            $this->gazTankService->create(
                $request->float('volume'),
                $co2Percent,
                $n2Percent,
                $request->input('name'),
            ),
        );
    }
}
