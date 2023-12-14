<?php

namespace App\Http\Requests\Admin\Halls;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SeatsDataRowRequest extends FormRequest
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
            'seats_count' => 'required|int',
            'seats_type' =>'required|exists:seat_types,id',
            'count_row' =>'required|int',
        ];
    }
}
