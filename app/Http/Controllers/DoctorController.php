<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorCreateRequest;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DoctorRequest;
use App\Models\Schedule;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
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

            $doctors = User::role('Doctor')
                ->where('name','LIKE','%'.$filterValue.'%')
                ->simplePaginate(10);

            return view('admin.doctors.index', ["doctors" => $doctors, "filterValue" => $filterValue]);
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
            $specialties = Specialty::all();
            return view('admin.doctors.create', compact('specialties'));
        }
    }

    public function store(DoctorCreateRequest $request)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $doctor = $request->all();

            $user = User::create($doctor);

            $user->roles()->sync(2);

            $user->specialty()->attach($request->input('specialties'));

            return redirect()->action([DoctorController::class, 'index'])
                        ->with('success-create', 'Doctor creado con éxito');
        }
    }

    public function show(User $doctor)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $doctors = DB::table('users')
                ->where('users.id', $doctor->id)
                ->get();

            $specialties = DB::table('specialty_user')
                ->join('specialties', 'specialty_user.specialty_id', '=', 'specialties.id')
                ->select('specialties.name')
                ->where('user_id', $doctor->id)
                ->get();

            $schedules = DB::table('schedules')
                ->where('user_id', $doctor->id)
                ->where('active', true)
                ->get();

            $days = [
                    'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'
                    ];

            $profile = DB::table('profiles')->select('photo')
                ->where('user_id', $doctor->id)
                ->get();

            return view('admin.doctors.show', compact('doctors', 'specialties', 'schedules', 'days', 'profile'));
        }
    }

    public function edit(User $doctor)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $specialties = Specialty::all();

            $specialty_ids = $doctor->specialty()->pluck('specialties.id');

            return view('admin.doctors.edit', compact('doctor', 'specialties', 'specialty_ids'));
        }
    }

    public function update(DoctorRequest $request, User $doctor)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $datosDoctor = [
                'name' => ucwords(strtolower($request->input('name'))),
                'email' => $request->input('email'),
                'ci' => $request->input('ci'),
                'phone' => $request->input('phone'),
            ];

            $doctor = User::find($doctor->id);

            if (!$doctor)
            {
                abort(404, 'Doctor no encontrado');
            }
            else
            {
                $doctor->update($datosDoctor);

                $doctor->specialty()->sync($request->input('specialties'));

                return redirect()->action([DoctorController::class, 'index'], compact('doctor'))
                                    ->with('success-update', 'Doctor modificado con éxito');
            }
        }
    }

    public function destroy(User $doctor)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $doctor->delete();

            return redirect()->action([DoctorController::class, 'index'], compact('doctor'))
                                    ->with('success-delete', 'Doctor eliminado con éxito');
        }
    }

    private $days = [
        'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'
    ];

    public function index_schedule($id)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $schedules = Schedule::where('user_id', $id)->get();
            $name_doctor = User::where('id', $id)->value('name');

            if (count($schedules) > 0)
            {
                $schedules->map(function($schedules){
                    $schedules->morning_start = (new Carbon($schedules->morning_start))->format('H:i');
                    $schedules->morning_end = (new Carbon($schedules->morning_end))->format('H:i');
                    $schedules->afternoon_start = (new Carbon($schedules->afternoon_start))->format('H:i');
                    $schedules->afternoon_end = (new Carbon($schedules->afternoon_end))->format('H:i');
                });
            }
            else
            {
                $schedules = collect();
                for($i=0; $i<7; ++$i)
                {
                    $schedules->push(new Schedule());
                }
            }

            $days = $this->days;

            return view('admin.doctors.index_schedule', compact('days', 'schedules', 'id', 'name_doctor'));
        }
    }

    public function store_schedule(Request $request, $id)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $active = $request->input('active') ?: [];
            $morning_start = $request->input('morning_start');
            $morning_end = $request->input('morning_end');
            $afternoon_start = $request->input('afternoon_start');
            $afternoon_end = $request->input('afternoon_end');

            $errors = [];

            for ($i=0; $i<7; ++$i)
            {
                if($morning_start[$i] > $morning_end[$i])
                {
                    $errors [] = 'En el intervalo de las horas del turno de la mañana del día ' . $this->days[$i] . '.';
                }

                if($afternoon_start[$i] > $afternoon_end[$i])
                {
                    $errors [] = 'En el intervalo de las horas del turno de la tarde del día ' . $this->days[$i] . '.';
                }

                Schedule::updateOrCreate(
                    [
                        'day' => $i,
                        'user_id' => $id,
                    ],
                    [
                        'active' => in_array($i, $active),
                        'morning_start' => $morning_start[$i],
                        'morning_end' => $morning_end[$i],
                        'afternoon_start' => $afternoon_start[$i],
                        'afternoon_end' => $afternoon_end[$i],
                    ]
                );
            }
            if (count($errors) > 0)
            {
                return back()->with(compact('errors'));
            }

            $success_create = 'Los cambios se han guardado correctamente.';
            return back()->with(compact('success_create'));
        }
    }
}
