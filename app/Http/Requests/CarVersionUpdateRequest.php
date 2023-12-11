<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarVersionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'car_model_id' => ['required', 'exists:car_models,id'],
            'name' => ['required', 'max:255', 'string'],
            'year' => ['required', 'numeric'],
            'initial_price' => ['required', 'numeric'],
            'photo' => ['nullable', 'file'],
        ];
    }
}
