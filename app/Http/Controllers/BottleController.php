<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use App\Services\BottleService;
use Exception;
use Illuminate\Http\Request;
use Tests\Feature\Http\Controllers\BottleControllerTest;

/**
 * @see BottleControllerTest
 */
class BottleController extends Controller
{

    public function __construct(private readonly BottleService $bottleService)
    {
    }

    public function show(Bottle $bottle)
    {
        return $this->jsonResponse(
            $this->bottleService->show($bottle),
        );
    }

    /**
     * @throws Exception
     */
    public function create(Request $request)
    {
        $request->validate([
            'volume' => 'required|integer|min:100',
            'count'  => 'integer|between:1,100',
        ]);

        return $this->jsonCreatedResponse(
            $this->bottleService->create(
                $request->integer('volume'),
                $request->integer('count', 1),
            ),
        );
    }
}
