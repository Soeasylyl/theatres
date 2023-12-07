<?php

namespace App\Http\Requests\Admin\Theatres;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TheatreRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'theatreImages' => 'nullable|array',
            'theatreImages.*' => 'sometimes|file|mimetypes:image/jpeg,image/png,image/jpg|max:10240',
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
            'address.max' => 'Количество символов не более :max',
            'description.max' => 'Количество символов не более :max',
        ];
    }
}
