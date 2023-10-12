<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'schedule_time' => 'required',
            'schedule_date' => 'required',
            'doctor_id' => 'exists:users,id',
            'specialty_id' => 'exists:specialties,id'
        ];
    }

    public function messages()
    {
        return [
            'schedule_time.required' => 'Debe seleccionar una hora válida para su cita.',

            'schedule_date.required' => 'Debe seleccionar una fecha válida para su cita.',

            'doctor_id.exists' => 'Debe seleccionar un doctor.',

            'specialty_id.exists' => 'Debe seleccionar una especialidad.',
        ];
    }
}
