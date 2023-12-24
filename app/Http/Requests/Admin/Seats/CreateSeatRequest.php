<?php

namespace App\Http\Requests\Admin\Seats;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSeatRequest extends FormRequest
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
            'hall_id' => 'required|int|exists:halls,id',
            'row' => 'required|int',
            'number' => 'required|int',
            'position_x' => 'required|numeric',
            'position_y' => 'required|numeric',
            'seat_type_id' => 'required|int|exists:seat_types,id',
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
            'hall_id.exists' => 'Такого зала не существует',
            'seat_type_id.exists' => 'Такого типа мест не существует',
        ];
    }
}
