<?php

namespace App\Http\Controllers;

use App\Services\MaterialService;
use Tests\Feature\Http\Controllers\MaterialControllerTest;

/**
 * @see MaterialControllerTest
 */
class MaterialController extends Controller
{

    public function __construct(private readonly MaterialService $materialService)
    {
    }

    public function index()
    {
        return $this->jsonResponse(
            $this->materialService->listMaterialsByType(),
        );
    }
}
