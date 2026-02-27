<?php

namespace App\Http\Controllers;

use App\Models\Keg;
use App\Services\KegService;
use Tests\Feature\Http\Controllers\KegControllerTest;

/**
 * @see KegControllerTest
 */
class KegController extends Controller
{

    public function __construct(private readonly KegService $kegService)
    {
    }

    public function show(Keg $keg)
    {
        return $this->jsonResponse(
            $this->kegService->show($keg),
        );
    }
}
