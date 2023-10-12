<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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

            $users = User::where('name', 'like', '%'.$filterValue.'%')
                        ->simplePaginate(10);

            return view('admin.users.index', compact('users', 'filterValue'));
        }
    }

    public function edit(User $user)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            //Recuperar el listado de roles
            $roles = Role::all();

            return view('admin.users.edit', compact('user', 'roles'));
        }
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            //Llenar la tabla intermedia
            $user->roles()->sync($request->role);

            return redirect()->route('users.edit', $user)
                            ->with('success-update', 'Rol establecido con éxito');
        }
    }

    public function destroy(User $user)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $user->delete();

            return redirect()->action([UserController::class, 'index'])
                            ->with('success-delete', 'Usuario eliminado con éxito');
        }
    }
}
