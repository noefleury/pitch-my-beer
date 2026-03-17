<?php

namespace App\Http\Requests;

use App\Enums\BeerStatus;
use App\Models\Beer;
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
            'volume'  => 'required|decimal:0,2|min:0.5',
            'beer_id' => ['required', 'integer', Rule::exists('beers', 'id')],
            'keg_id'  => ['required', 'integer', Rule::exists('kegs', 'id')->withoutTrashed()],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        $volume = $this->float('volume');
        $beer   = Beer::query()->findOrFail($this->integer('beer_id'));
        $keg    = Keg::query()->findOrFail($this->integer('keg_id'));

        return [
            function (Validator $validator) use ($volume, $beer, $keg) {
                if ($beer->status === BeerStatus::Consumed) { // maybe adapt this
                    $validator->errors()->add(
                        'beer',
                        'The given beer is already consumed'
                    );
                }
                if ($keg->keggings()->exists()) { // maybe add force mode
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
                if ((float)$beer->keggings()->sum('volume') + $volume > $beer->volume) {
                    $validator->errors()->add(
                        'volume',
                        'This volume cannot be taken from the given beer'
                    );
                }
            },
        ];
    }
}
