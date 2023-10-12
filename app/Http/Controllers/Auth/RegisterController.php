<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Notifications\WelcomeEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected $messages = [
        'name.required' => 'El campo nombre es obligatorio.',
        'name.regex' => 'El campo nombre solo admite texto.',
        'email.required' => 'El campo correo electrónico es obligatorio.',
        'email.email' => 'El formato del correo electrónico no es válido.',
        'email.unique' => 'El correo electrónico ya está registrado.',
        'password.required' => 'El campo contraseña es obligatorio.',
        'password.min' => 'La contraseña debe tener al menos :min caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
        'ci.required' => 'El campo cedula es obligatorio.',
        'ci.numeric' => 'El campo cedula debe tener solo números.',
        'ci.digits' => 'El campo cedula debe tener 10 números.',
        'type_patient.required' => 'Debe seleccionar que tipo de paciente es.',
        'date_birth.required' => 'El campo fecha es obligatorio.',
        'date_birth.date' => 'Formato de fecha inválido.',
        'phone.required' => 'El campo teléfono es obligatorio.',
        'phone.numeric' => 'El campo teléfono debe tener solo números.',
        'phone.digits' => 'El campo teléfono debe tener 10 números.',
    ];

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'ci' => ['required', 'numeric', 'digits:10'],
            'type_patient' => ['required'],
            'date_birth' => ['required', 'date'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $this->messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => ucwords($data['name']),
            'email' => $data['email'],
            'ci' => $data['ci'],
            'type_patient' => $data['type_patient'],
            'date_birth' => $data['date_birth'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $user->notify(new WelcomeEmail($user));
        $user->roles()->sync(3);

        return $user;
    }
}
