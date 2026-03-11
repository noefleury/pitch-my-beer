<?php

namespace App\Http\Controllers;

use App\Enums\TapType;
use App\Models\Tap;
use App\Services\TapService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tests\Feature\Http\Controllers\TapControllerTest;

/**
 * @see TapControllerTest
 */
class TapController extends Controller
{

    public function __construct(private readonly TapService $tapService)
    {
    }

    public function show(Tap $tap)
    {
        return $this->jsonResponse(
            $this->tapService->show($tap),
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::enum(TapType::class)],
            'name' => 'nullable|alpha_dash|min:3',
        ]);

        return $this->jsonCreatedResponse(
            $this->tapService->create(
                TapType::from($request->string('type')),
                $request->input('name'),
            ),
        );
    }

    public function getOnTaps()
    {
        return $this->jsonResponse(
            $this->tapService->getOnTaps(),
        );
    }
}
