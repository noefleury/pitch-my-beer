<?php

namespace App\Http\Requests;

use App\Models\Bottle;
use App\Models\Fermentation;
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
            'fermentation_id' => ['required', 'integer', Rule::exists('fermentations', 'id')],
            'bottle_ids'      => ['required', 'array'],
            'bottle_ids.*'    => ['required', 'integer', Rule::exists('bottles', 'id')],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        $fermentation = Fermentation::query()->findOrFail($this->integer('fermentation_id'));
        $bottlesQuery = Bottle::query()->whereIn('id', $this->array('bottle_ids'));

        return [
            function (Validator $validator) use ($fermentation, $bottlesQuery) {
                if ($bottlesQuery->clone()->whereHas('bottlings', fn($query) => $query->whereNull('deleted_at'))->exists()) {
                    $validator->errors()->add(
                        'bottle_ids',
                        'The given bottles contain one which is already bottled'
                    );
                }
                // maybe adapt to handle little more
                // todo should check what is already consumed from fermentation
                if ((float)$bottlesQuery->sum('volume') / 1000 > $fermentation->volume) {
                    $validator->errors()->add(
                        'volume',
                        'This volume cannot be taken from the given fermentation'
                    );
                }
            },
        ];
    }
}
