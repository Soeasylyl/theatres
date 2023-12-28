<?php

namespace App\Http\Requests\Admin\Screenings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateScreeningRequest extends FormRequest
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
            'theatre' => 'required|int|exists:theatres,id',
            'hall' => 'required|int|exists:halls,id',
            'movie' => 'required|int|exists:movies,id',
            'price' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d\TH:i',
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
            'theatre.exists' => 'Такого кинотеатра не существует в базе данных',
            'theatre.required' => 'Необходимо выбрать кинотеатр',
            'hall.exists' => 'Такого зала не существует в базе данных',
            'movies.exists' => 'Такого фильма не существует в базе данных',
            'hall.required' => 'Необходимо выбрать зал',
            'date.date_format' => 'Не верный формат даты',
        ];
    }
}
