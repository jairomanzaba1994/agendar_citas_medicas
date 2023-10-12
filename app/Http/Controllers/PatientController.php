<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\DoctorRequest;
use App\Notifications\WelcomeEmail;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $filterValue = $request->input('filterValue');

            $patients = User::role('Paciente')
                ->where('name', 'like', '%'.$filterValue.'%')
                ->simplePaginate(10);

            return view('admin.patients.index', ["patients" => $patients, "filterValue" => $filterValue]);
        }
    }

    public function create()
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            return view('admin.patients.create');
        }
    }

    public function store(UserRequest $request)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $patient = $request->all();

            $user = User::create($patient);

            $user->notify(new WelcomeEmail($user));
            $user->roles()->sync(3);

            return redirect()->action([PatientController::class, 'index'])
                        ->with('success-create', 'Paciente creado con éxito');
        }
    }

    public function show(User $patient)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $patients = DB::table('users')
            ->where('users.id', $patient->id)
            ->get();

            $profile = DB::table('profiles')->select('photo')
                ->where('user_id', $patient->id)
                ->get();

            return view('admin.patients.show', compact('patients', 'profile'));
        }
    }

    public function edit(User $patient)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            return view('admin.patients.edit', compact('patient'));
        }
    }

    public function update(DoctorRequest $request, User $patient)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $datosPatient = [
                'name' => ucwords(strtolower($request->input('name'))),
                'email' => $request->input('email'),
                'ci' => $request->input('ci'),
                'type_patient' => $request->input('type_patient'),
                'date_birth' => $request->input('date_birth'),
                'phone' => $request->input('phone'),
            ];

            $patient = User::find($patient->id);

            if (!$patient)
            {
                abort(404, 'Especialidad no encontrada');
            }
            else
            {
                $patient->update($datosPatient);

                return redirect()->action([PatientController::class, 'index'], compact('patient'))
                                    ->with('success-update', 'Paciente modificado con éxito');
            }
        }
    }

    public function destroy(User $patient)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $patient->delete();

            return redirect()->action([PatientController::class, 'index'], compact('patient'))
                                    ->with('success-delete', 'Paciente eliminado con éxito');
        }
    }
}
