<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $profile = Auth::user();

            return view('profiles.index', compact('profile'));
        }
    }

    public function edit(Profile $profile)
    {
        $this->authorize('view', $profile);
        return view('profiles.edit', compact('profile'));
    }

    public function update(DoctorRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        $user = Auth::user();

        if($request->hasFile('photo')){
            //Eliminar foto anterior
            File::delete(public_path('storage/' . $profile->photo));
            //Asignar nueva foto
            $photo = $request['photo']->store('profiles');
        }else{
            $photo = $user->profile->photo;
        }

        //Asignar nombre y correo
        $profile->user->name = ucwords(strtolower($request->name));
        $profile->user->email = $request->email;

        $profile->user->type_patient = $request->type_patient;
        $profile->user->date_birth = $request->date_birth;

        $profile->user->ci = $request->ci;
        $profile->user->phone = $request->phone;

        //Asignar foto
        $user->profile->photo = $photo;

        //Guardar campos de usuario
        $profile->user->save();
        //Guardar campos de perfil
        $user->profile->save();

        return redirect()->route('profiles.index')
                            ->with('success-update', "Datos modificados con éxito");
    }

}
