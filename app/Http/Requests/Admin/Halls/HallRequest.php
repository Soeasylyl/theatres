<?php

namespace App\Http\Requests\Admin\Halls;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HallRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:1000',
            'rows' => 'array',
            'rows.*' => 'required|array',
            'rows.*.*.seatNumber' => 'required|int',
            'rows.*.*.seatsTypeId' => 'required|exists:seat_types,id',
            'hallImages' => 'nullable|array',
            'hallImages.*' => 'sometimes|file|mimetypes:image/jpeg,image/png,image/jpg|max:10240',
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
            'name.max' => 'Название кинотеатра не может быть длиннее :max символов',
            'description.max' => 'Описание кинотеатра не может быть длиннее :max символов',
            'hallImages.*.mimetypes' => 'Поддерживаемые форматы изображений: jpeg, jpg, png,',
        ];
    }
}
