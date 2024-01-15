<?php

namespace App\Http\Requests\Public;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ajaxCheckSeatsRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'seatIds' => ['required', 'json'],
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
