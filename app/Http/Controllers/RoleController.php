<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $roles = Role::simplePaginate(10);

            return view('admin.roles.index', compact('roles'));
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
            $permissions = Permission::all();

            return view('admin.roles.create', compact('permissions'));
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
            $request->validate([
                'name' => 'required',
            ]);

            $role = Role::create([
                'name' => $request->name
            ]);

            $role->permissions()->sync($request->permissions);

            return redirect()->action([RoleController::class, 'index'])
                                ->with('success-create', 'Rol creado con éxito');
        }
    }

    public function edit(Role $role)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $permissions = Permission::all();

            return view('admin.roles.edit', compact('permissions', 'role'));
        }
    }

    public function update(Request $request, Role $role)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $request->validate([
                'name' => 'required',
            ]);

            $role->update([
                'name' => $request->name
            ]);

            $role->permissions()->sync($request->permissions);

            return redirect()->action([RoleController::class, 'index'])
                                ->with('success-update', 'Rol modificado con éxito');
        }
    }

    public function destroy(Role $role)
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        else
        {
            $role->delete();

            return redirect()->action([RoleController::class, 'index'])
                                ->with('success-delete', 'Rol eliminado con éxito');
        }
    }
}
