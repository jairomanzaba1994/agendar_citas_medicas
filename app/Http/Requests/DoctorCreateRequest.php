<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'email' => 'required|string|email|max:255',
            'ci' => 'required|numeric|digits:10',
            'phone' => 'required|numeric|digits:10',
            'type_patient' => 'nullable',
            'date_birth' => 'nullable',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser texto.',
            'name.regex' => 'El campo nombre solo admite texto.',

            'email.required' => 'El campo correo es obligatorio.',
            'email.email' => 'Debe ser un correo válido.',
            'email.max' => 'Máximo 255 caracteres.',

            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.numeric' => 'El campo teléfono debe tener solo números.',
            'phone.digits' => 'El campo teléfono debe tener 10 números.',

            'ci.required' => 'El campo cedula es obligatorio.',
            'ci.numeric' => 'El campo cedula debe tener solo números.',
            'ci.digits' => 'El campo cedula debe tener 10 números.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
