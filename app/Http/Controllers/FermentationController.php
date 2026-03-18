<?php

namespace App\Http\Controllers;

use App\Enums\FermenterType;
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

    public function create(Request $request)
    {
        $request->validate([
            'wort_id'        => ['required', Rule::exists('worts', 'id')],
            'fermenter_id'   => 'required|integer', // todo FormRequest to dynamically check 'exists'
            'fermenter_type' => ['required', Rule::enum(FermenterType::class)],
            'volume'         => 'required|decimal:0,2|min:2.5',
        ]);

        $this->fermentationService->create(
            $request->integer('wort_id'),
            $request->integer('fermenter_id'),
            $request->enum('fermenter_type', FermenterType::class),
            $request->float('volume'),
        );

        return $this->jsonCreatedResponse();
    }
}
