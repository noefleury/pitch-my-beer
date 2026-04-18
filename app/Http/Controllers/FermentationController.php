<?php

namespace App\Http\Controllers;

use App\Enums\FermenterType;
use App\Models\Fermentation;
use App\Services\FermentationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tests\Feature\Http\Controllers\FermentationControllerTest;

/**
 * @see FermentationControllerTest
 */
class FermentationController extends Controller
{

    public function __construct(private readonly FermentationService $fermentationService)
    {
    }

    public function list()
    {
        return $this->jsonResponse(
            $this->fermentationService->list(),
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'fermenter_id'   => 'required|integer', // todo FormRequest to dynamically check 'exists'
            'fermenter_type' => ['required', Rule::enum(FermenterType::class)],
            'volume'         => 'required|decimal:0,2|min:2.5',
        ]);

        $this->fermentationService->create(
            $request->integer('fermenter_id'),
            $request->enum('fermenter_type', FermenterType::class),
            $request->float('volume'),
        );

        return $this->jsonCreatedResponse();
    }

    public function updateGravity(Request $request, Fermentation $fermentation)
    {
        $request->validate([
            'gravity' => 'decimal:0,3',
        ]);

        $this->fermentationService->updateGravity(
            $fermentation,
            $request->float('gravity'),
        );

        return $this->emptyResponse();
    }
}
