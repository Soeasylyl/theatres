<?php

namespace App\Http\Requests;

use App\Enums\RolesUsersEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminCreateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'regex:/\+375\d{9}/', 'min:13', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'max:50'],
            'role' => ['nullable', Rule::in(RolesUsersEnum::toArray())],
            'cinema' => ['nullable', 'exists:cinemas,id'],
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
            'phone.regex' => 'Номер телефона должен начинаться с "+375" и состоять из 9 цифр.',
            'phone.max' => 'Номер телефона не может быть длиннее или короче 13 символов.',
        ];
    }
}
