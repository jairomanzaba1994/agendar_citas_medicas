<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialtyRequest;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SpecialtyController extends Controller
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

            $specialties = DB::table('specialties')
                ->where('name','LIKE','%'.$filterValue.'%')
                ->simplePaginate(6);

            return view('admin.specialties.index', ["specialties" => $specialties, "filterValue" => $filterValue]);
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
            return view('admin.specialties.create');
        }
    }

    public function store(SpecialtyRequest $request)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $specialty = $request->all();

            Specialty::create($specialty);

            return redirect()->action([SpecialtyController::class, 'index'])
                        ->with('success-create', 'Especialidad creada con éxito');
        }
    }

    public function show(Specialty $specialty)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $specialties = DB::table('specialties')
                        ->where('specialties.id', $specialty->id)
                        ->get();

            return view('admin.specialties.show', compact('specialties'));
        }
    }

    public function edit(Specialty $specialty)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            return view('admin.specialties.edit', compact('specialty'));
        }
    }

    public function update(Request $request, Specialty $specialty)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $datosSpecialty = [
                'name' => ucwords(strtolower($request->input('name'))),
                'description' => $request->input('description'),
            ];

            $specialty = Specialty::find($specialty->id);

            if (!$specialty)
            {
                abort(404, 'Especialidad no encontrado');
            }
            else
            {
                $specialty->update($datosSpecialty);

                return redirect()->action([SpecialtyController::class, 'index'], compact('specialty'))
                                    ->with('success-update', 'Especialidad modificada con éxito');
            }
        }
    }

    public function destroy(Specialty $specialty)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $specialty->delete();

            return redirect()->action([SpecialtyController::class, 'index'], compact('specialty'))
                                    ->with('success-delete', 'Especialidad eliminada con éxito');
        }
    }
}
