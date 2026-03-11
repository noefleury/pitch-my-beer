<?php

namespace App\Http\Controllers;

use App\Models\Keg;
use App\Services\KegService;
use Illuminate\Http\Request;
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

    public function getRelations(Keg $keg)
    {
        return $this->jsonResponse(
            $this->kegService->getRelationsData($keg),
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'volume' => 'required|decimal:0,2',
            'name'   => 'nullable|alpha_dash|min:3',
        ]);

        return $this->jsonCreatedResponse(
            $this->kegService->create(
                $request->float('volume'),
                $request->input('name'),
            ),
        );
    }

}
