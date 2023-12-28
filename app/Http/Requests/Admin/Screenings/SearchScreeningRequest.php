<?php

namespace App\Http\Requests\Admin\Screenings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchScreeningRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|max:40',
            "fTheatre" => 'nullable|int|exists:theatres,id',
            "fDate" => 'nullable|date',
            "fScreenings" => 'nullable', Rule::in(['all', 'upcoming', 'completed']),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'search.max' => 'Максимум может быть :max символов',
        ];
    }
}
