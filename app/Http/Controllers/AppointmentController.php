<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Specialty;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AppointmentRequest;
use App\Models\CancelledApointment;
use App\Models\User;
use App\Notifications\CancelScheduleAdminEmail;
use App\Notifications\CancelScheduleDoctorEmail;
use App\Notifications\CancelScheduleEmail;
use App\Notifications\ConfirmScheduleEmail;
use Spatie\Permission\Models\Role;
use Termwind\Components\Element;

class AppointmentController extends Controller
{
    public function index()
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $specialties = Specialty::all();

            return view('admin.appointments.index', compact('specialties'));
        }
    }

    public function doctors(Specialty $specialty)
    {
        return $specialty->users()->get([
            'users.id',
            'users.name'
        ]);
    }

    public function store(AppointmentRequest $request)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $data = $request->only([
                'schedule_date',
                'schedule_time',
                'doctor_id',
                'specialty_id',
            ]);

            $existAppointment = Appointment::where('schedule_date', $data['schedule_date'])
                                    ->where('schedule_time', $data['schedule_time'])
                                    ->where('doctor_id', $data['doctor_id'])
                                    ->where('specialty_id', $data['specialty_id'])
                                    ->where('status', '!=', 'Cancelada')
                                    ->first();

	    $horaActual = Carbon::now();
            
            $horaAcFor = $horaActual->format('H:i');
            
            if ($horaAcFor < '22:00') {
                $horaRestada = $horaActual->addHours(2);
                $horaFormateada = $horaRestada->format('H:i');
            } else {
                $horaFormateada = $horaAcFor;
            }
            
            $fechaActual = Carbon::now()->format('Y-m-d');

            if ($existAppointment)
            {
                $notification = 'Ya existe una cita con este doctor.';
                return back()->with(compact('notification'));
            }
            else
            {
                if ($data['schedule_time'] < $horaFormateada && $data['schedule_date'] == $fechaActual) {
                    $notification = 'Esta hora ya no está disponible, debe realizar cita mínimo con dos horas de anticipación.';
                    return back()->with(compact('notification'));
                } else {
                    $data['patient_id'] = auth()->id();
    
                    Appointment::create($data);
    
                    $notification = 'La cita se ha realizado correctamente.';
                    return redirect()->action([AppointmentController::class, 'meetings_index'])
                        ->with(compact('notification'));
                }
            }
        }
    }

    public function hours(Request $request)
    {
        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
            'doctor_id' => 'required|exists:users,id'
        ];

        $this->validate($request, $rules);

        $date = $request->input('date');
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);
        $doctorId = $request->input('doctor_id');

        $horario = Schedule::where('active', true)
            ->where('day', $day)
            ->where('user_id', $doctorId)
            ->first([
                'morning_start', 'morning_end',
                'afternoon_start', 'afternoon_end'
            ]);

            if (!$horario)
            {
                return [];
            }

            $morningIntervalos = $this->getIntervalos(
                $horario->morning_start, $horario->morning_end, $doctorId, $date
            );

            $afternoonIntervalos = $this->getIntervalos(
                $horario->afternoon_start, $horario->afternoon_end, $doctorId, $date
            );

            $data = [];
            $data['morning'] = $morningIntervalos;
            $data['afternoon'] = $afternoonIntervalos;

            return $data;
    }

    private function getIntervalos($start, $end, $doctorId, $date)
    {
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervalos = [];
        while($start < $end)
        {
            $intervalo = [];
            $intervalo['start'] = $start->format('H:i');

            $exists = Appointment::where('doctor_id', $doctorId)
                            ->where('schedule_date', $date)
                            ->where('schedule_time', $start->format('H:i:s'))
                            ->where('status', '!=', 'Cancelada')
                            ->exists();

            $start->addMinutes(30);
            $intervalo['end'] = $start->format('H:i');

            if(!$exists){
                $intervalos [] = $intervalo;
            }
        }
        return $intervalos;
    }

    public function meetings_index ()
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $user = Auth::user();
            $roles = $user->roles;
            $roleName = $roles->pluck('name')->toArray()[0];
            $role = '';

            if ($roleName === 'Administrador')
            {
                $role = 'Administrador';
                //Consultas para administradores
                $confirmedAppointments = Appointment::all()
                ->where('status', 'Confirmada');

                $pendientAppointments = Appointment::all()
                ->where('status', 'Reservada');

                $oldAppointments = Appointment::all()
                ->whereIn('status', ['Atendida', 'Cancelada']);
            }
            else if($roleName === 'Doctor')
            {
                $role = 'Doctor';
                //Consultas para doctores
                $confirmedAppointments = Appointment::all()
                ->where('status', 'Confirmada')
                ->where('doctor_id', auth()->id());

                $pendientAppointments = Appointment::all()
                ->where('status', 'Reservada')
                ->where('doctor_id', auth()->id());

                $oldAppointments = Appointment::all()
                ->whereIn('status', ['Atendida', 'Cancelada'])
                ->where('doctor_id', auth()->id());
            }
            else if ($roleName === 'Paciente')
            {
                $role = 'Paciente';
                //Consultas para pacientes
                $confirmedAppointments = Appointment::all()
                    ->where('status', 'Confirmada')
                    ->where('patient_id', auth()->id());

                $pendientAppointments = Appointment::all()
                    ->where('status', 'Reservada')
                    ->where('patient_id', auth()->id());

                $oldAppointments = Appointment::all()
                    ->whereIn('status', ['Atendida', 'Cancelada'])
                    ->where('patient_id', auth()->id());
            }

            return view('admin.appointments.meetings_index', compact('confirmedAppointments', 'pendientAppointments', 'oldAppointments', 'role'));
        }
    }

    public function meetings_cancel(Appointment $appointment, $id, Request $request)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $appointment = Appointment::find($id);
            $user = Auth::user();
            $role = $user->roles->pluck('name')->toArray();

            if (!$appointment)
            {
                abort(404, 'Cita no encontrada');
            }
            else
            {
                if ($request->has('justification'))
                {
                    $cancellation = new CancelledApointment();
                    $cancellation->justification = $request->input('justification');
                    $cancellation->cancelled_by_id = auth()->id();

                    $appointment->cancellation()->save($cancellation);
                }

                if ($appointment->status === 'Confirmada' && $role[0] != 'Paciente')
                {
                    $user = User::find($appointment->patient_id);
                    $justification = $request->justification;
                    $user->notify(new CancelScheduleEmail($user, $appointment, $justification));
                }

                if ($role[0] === 'Paciente')
                {
                    $user = User::find($appointment->doctor_id);
                    $justification = $request->justification;
                    $user->notify(new CancelScheduleDoctorEmail($user, $appointment, $justification));
                    $primerRolAdmin = Role::where('name', 'Administrador')->first();
                    $user = User::find($primerRolAdmin->id);
                    $user->notify(new CancelScheduleAdminEmail($user, $appointment, $justification));
                }

                $appointment->status = 'Cancelada';

                $appointment->save();

                return redirect()->action([AppointmentController::class, 'meetings_index'])
                    ->with('success-update', 'Cita cancelada con éxito.');
            }
        }
    }

    public function form_cancel(Appointment $appointment, $id)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $appointment = Appointment::find($id);

            if (!$appointment)
            {
                abort(404, 'Cita no encontrada');
            }
            else
            {
                $user = Auth::user();
                $role = $user->roles->pluck('name')->toArray();
                if($role[0] === 'Doctor')
                {
                    $role = 'Doctor';
                }elseif($role[0] === 'Paciente')
                {
                    $role = 'Paciente';
                }elseif($role[0] === 'Administrador')
                {
                    $role = 'Administrador';
                }

                $carbonFecha = new Carbon($appointment->schedule_date);
                $fecha = $carbonFecha->format('d-m-Y');

                if($appointment->status == 'Confirmada')
                {
                    return view('admin.appointments.cancel', compact('appointment', 'fecha', 'role'));
                }
                else
                {
                    return redirect()->action([AppointmentController::class, 'meetings_index'])
                        ->with('success-update', 'Cita cancelada con éxito.');
                }

            }
        }
    }

    public function show (Appointment $appointment, $id)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $appointment = Appointment::find($id);

            if (!$appointment)
            {
                abort(404, 'Cita no encontrada');
            }
            else
            {
                $user = Auth::user();
                $role = $user->roles->pluck('name')->toArray();
                if($role[0] === 'Doctor')
                {
                    $role = 'Doctor';
                }elseif($role[0] === 'Paciente')
                {
                    $role = 'Paciente';
                }elseif($role[0] === 'Administrador')
                {
                    $role = 'Administrador';
                }

                return view('admin.appointments.show', compact('appointment', 'role'));
            }
        }
    }

    public function meetings_confirm(Appointment $appointment, $id)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $appointment = Appointment::find($id);

            if (!$appointment)
            {
                abort(404, 'Cita no encontrada');
            }
            else
            {
                $user = User::find($appointment->patient_id);
                $user->notify(new ConfirmScheduleEmail($user, $appointment));

                $appointment->status = 'Confirmada';

                $appointment->save();

                return redirect()->action([AppointmentController::class, 'meetings_index'])
                        ->with('success-update', 'Cita confirmada con éxito.');
            }
        }
    }

    public function meetings_attend(Appointment $appointment, $id)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $appointment = Appointment::find($id);

            if (!$appointment)
            {
                abort(404, 'Cita no encontrada');
            }
            else
            {
                $appointment->status = 'Atendida';

                $appointment->save();

                return redirect('meetings')->with('success-update', 'Cita marcada como atendida.');
            }
        }
    }
}
