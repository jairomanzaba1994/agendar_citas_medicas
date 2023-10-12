<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    private $days = [
        'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'
    ];

    public function index()
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $schedules = Schedule::where('user_id', auth()->id())->get();

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

            return view('admin.schedules.index', compact('days', 'schedules'));
        }
    }

    public function store(Request $request)
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
                        'user_id' => auth()->id()
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
