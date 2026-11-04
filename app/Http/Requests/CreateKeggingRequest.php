<?php

namespace App\Http\Requests;

use App\Models\Fermentation;
use App\Models\Keg;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CreateKeggingRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'volume'          => 'required|decimal:0,2|min:0.5',
            'fermentation_id' => ['required', 'integer', Rule::exists('fermentations', 'id')],
            'keg_id'          => ['required', 'integer', Rule::exists('kegs', 'id')->whereNull('deleted_at')],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        $volume       = $this->float('volume');
        $fermentation = Fermentation::query()->findOrFail($this->integer('fermentation_id'));
        $keg          = Keg::query()->findOrFail($this->integer('keg_id'));

        return [
            function (Validator $validator) use ($volume, $fermentation, $keg) {
                if ($keg->keggings()->whereNull('deleted_at')->exists()) { // maybe add force mode
                    $validator->errors()->add(
                        'keg',
                        'The given keg is already kegged'
                    );
                }
                if ($keg->volume < $volume) {
                    $validator->errors()->add(
                        'volume',
                        'This volume cannot be filled in given keg'
                    );
                }
                // todo should check what is already consumed from beer
                if ((float)$fermentation->keggings()->sum('volume') + $volume > $fermentation->volume) {
                    $validator->errors()->add(
                        'volume',
                        'This volume cannot be taken from the given fermentation'
                    );
                }
            },
        ];
    }
}
