<?php

namespace App\Http\Requests\Admin\SeatTypes;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SeatTypeRequest extends FormRequest
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
            'seat_name' => 'required|string|max:30',
            'seat_description' => 'nullable|string|max:1000',
            'seat_amount' => 'required|numeric|min:0.1|max:999.99',
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
            'seat_description.max' => 'Описание цены за место должно быть не более 1000',
            'seat_amount.numeric' => 'Цена за место обязательно должна быть числом',
            'seat_amount.min' => 'Минимальное значчение цены за место 0.1',
            'seat_amount.max' => 'Максимальное значение цены за место 999.99',
        ];
    }
}
