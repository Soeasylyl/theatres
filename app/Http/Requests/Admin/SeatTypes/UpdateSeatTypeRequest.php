<?php

namespace App\Http\Requests\Admin\SeatTypes;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSeatTypeRequest extends FormRequest
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
            'seat_id' => 'required|exists:seat_types,id',
            'seat_name' => 'required|string|max:30',
            'seat_description' => 'nullable|string|max:1000',
            'seat_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
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
            'seat_id.exists' => 'Такой записи не существует в базе данных',
            'seat_description.max' => 'Описание типа места должно быть не более :max',
            'seat_amount.regex' =>  'Не верный формат цены за место, пример: 57.34 или 3.1'
        ];
    }
}
