<?php

namespace App\Http\Requests;

use App\Enums\FermenterType;
use App\Models\Fermenter;
use App\Models\Keg;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CreateBeerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            // common
            'name'           => 'required|string|min:3',
            'type'           => 'required|string|min:3',
            'is_homemade'    => 'required|boolean',
            'volume'         => 'required|decimal:0,2',

            // homemade
            'fermenter_type' => [
                'required_if:is_homemade,true',
                'missing_if:is_homemade,false',
                Rule::enum(FermenterType::class),
            ],
            'fermenter_id'   => 'required_if:is_homemade,true|missing_if:is_homemade,false',
            'og_gravity'     => 'required_if:is_homemade,true|missing_if:is_homemade,false|decimal:0,3',

            // bought
            'abv'            => 'required_if:is_homemade,false|missing_if:is_homemade,true|decimal:0,2',

        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->filled('fermenter_type') && $this->filled('fermenter_id')) {
                    $fermenterId = $this->integer('fermenter_id');
                    $fermenter   = match ($this->enum('fermenter_type', FermenterType::class)) {
                        FermenterType::Fermenter => Fermenter::query()->find($fermenterId),
                        FermenterType::Keg => Keg::query()->find($fermenterId),
                    };

                    // cannot find given fermenter
                    if (is_null($fermenter)) {
                        $validator->errors()->add(
                            'fermenter_id',
                            'The given fermenter is not existing for the specified type',
                        );
                    } else {
                        // fermenter is currently fermenting
                        if ($fermenter->fermentations()->exists()) {
                            $validator->errors()->add(
                                'fermenter_id',
                                'The given fermenter is currently fermenting',
                            );
                        }
                        // fermenter is not big enough
                        if ($fermenter->volume < $this->float('volume')) {
                            $validator->errors()->add(
                                'fermenter_id',
                                'The given fermenter have less volume than the given one',
                            );
                        }
                    }
                }
            },
        ];
    }
}
