<?php

namespace App\Http\Requests;

use App\Enums\BeerStatus;
use App\Models\Beer;
use App\Models\Bottle;
use App\Models\Keg;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CreateBottlingRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'beer_id'      => ['required', 'integer', Rule::exists('beers', 'id')],
            'bottle_ids'   => ['required', 'array'],
            'bottle_ids.*' => ['required', 'integer', Rule::exists('bottles', 'id')],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        $beer         = Beer::query()->findOrFail($this->integer('beer_id'));
        $bottlesQuery = Bottle::query()->whereIn('id', $this->array('bottle_ids'));

        return [
            function (Validator $validator) use ($beer, $bottlesQuery) {
                if ($beer->status === BeerStatus::Consumed) { // maybe adapt this
                    $validator->errors()->add(
                        'beer',
                        'The given beer is already consumed'
                    );
                }
                if ($bottlesQuery->has('bottlings')) {
                    $validator->errors()->add(
                        'bottle_ids',
                        'The given bottles contain one which is already bottled'
                    );
                }
                // maybe adapt to handle little more
                // todo should check what is already consumed from beer
                if ((float)$bottlesQuery->sum('volume') > $beer->volume) {
                    $validator->errors()->add(
                        'volume',
                        'This volume cannot be taken from the given beer'
                    );
                }
            },
        ];
    }
}
