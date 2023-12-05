<?php

namespace App\Http\Requests\Admin\Movies;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieRequest extends FormRequest
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
            'name' => 'required|min:2|max:40',
            'date_start' =>'required|date_format:Y-m-d\TH:i',
            'session_duration' => 'required|date_format:H:i:s',
            'rating' => 'required|numeric|between:0,10|regex:/^\d+(\.\d{1,2})?$/',
            'age_limit' => 'required|integer|min:1|max:21',
            'description' => 'required|string|max:1000',
            'poster' => 'nullable|mimes:jpeg,jpg,png,svg',
            'frames' => 'nullable|array',
            'frames.*' => 'sometimes|file|mimetypes:image/jpeg,image/png,image/jpg,video/mp4,video/avi,video/mov,video/wmv|max:102400',
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
            'name.min' => 'Минимальное количество символов не меньше :min',
            'name.max' => 'Максимальное количество символов не должно привышать :max',
            'name.unique' => 'Название должно быть уникальным',
            'session_duration.regex' => 'Некорректный формат времени',
            'rating.between' => 'Рейтинг должен быть числом и находиться в промежутке от :min до :max',
            'rating.regex' => 'Рейтинг не может иметь более 2х знаков после запятой',
            'age_limit.int' => 'Может содержать только цифры',
            'age_limit.max' => 'Максимальное возраст не более :max',
            'age_limit.min' => 'Минимальный возраст не меньше :min',
            'description.max' => 'Описание не должно содержать более :max символов',
            'poster.mimes' => 'Поддерживаемые форматы: jpg, jpeg, png',
            'frames.*.mimetypes' => 'Поддерживаемые форматы: jpeg, jpg, png, mp4, avi, mov, wmv',
            'frames.*.max' => 'Размер файла не должен превышать 100мб',
        ];
    }
}
