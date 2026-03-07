<?php

namespace App\Http\Controllers;

use App\Models\Tap;
use App\Services\TapService;
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

    public function getOnTaps()
    {
        return $this->jsonResponse(
            $this->tapService->getOnTaps(),
        );
    }
}
