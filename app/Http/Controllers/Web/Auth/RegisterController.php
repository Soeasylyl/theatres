<?php

namespace App\Http\Controllers\Web\Auth;

use App\DTO\Users\CreateUserDTO;
use App\Http\Controllers\Web\Admin\BaseAdminController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseAdminController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly UserService $userService)
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'regex:/\+375\d{9}/', 'min:13', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Номер телефона должен начинаться с "+375" и содержать 12 цифр в общей сложности, включая код страны.',
            'phone.max' => 'Номер телефона не может быть длиннее 13 символов.',
            'phone.min' => 'Номер телефона не может быть короче 13 символов.',
            'password.regex' => 'Поле :attribute должно содержать как минимум одну маленькую букву, одну заглавную букву и одну цифру.',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $dataDTO = new CreateUserDTO(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            password: $data['password'],
        );

        return $this->userService->createUser($dataDTO);
    }
}
