<?php

namespace App\Http\Requests\Admin\Seats;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

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
            'row' => 'required|int|min:0',
            'number' => 'required|int|min:0',
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
            'row.min' => 'Ряд не может быть отрицательным или равным 0',
            'number.min' => 'Номер места не может быть отрицательным или равным 0',
            'seat_type_id.exists' => 'Такого типа мест не существует',
        ];
    }

    /**
     *  Handle a failed validation attempt and respond with a JSON representation
     *  of the first validation error along with an HTTP 422 Unprocessable Entity status.
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    protected function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first(),
        ], 422));
    }
}
