<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Administrador']);
        $doctor = Role::create(['name' => 'Doctor']);
        $patient = Role::create(['name' => 'Paciente']);

        //Permisos para administrador
        Permission::create(['name' => 'specialties.index',
                            'description' => 'Ver especialidades'])->assignRole($admin);
        Permission::create(['name' => 'specialties.show',
                            'description' => 'Ver detalles de especialidades'])->assignRole($admin);
        Permission::create(['name' => 'specialties.create',
                            'description' => 'Crear especialidades'])->assignRole($admin);
        Permission::create(['name' => 'specialties.edit',
                            'description' => 'Editar especialidades'])->assignRole($admin);
        Permission::create(['name' => 'specialties.destroy',
                            'description' => 'Eliminar especialidades'])->assignRole($admin);

        Permission::create(['name' => 'doctors.index',
                            'description' => 'Ver doctores'])->assignRole($admin);
        Permission::create(['name' => 'doctors.show',
                            'description' => 'Ver detalles de doctores'])->assignRole($admin);
        Permission::create(['name' => 'doctors.create',
                            'description' => 'Crear doctores'])->assignRole($admin);
        Permission::create(['name' => 'doctors.edit',
                            'description' => 'Editar doctores'])->assignRole($admin);
        Permission::create(['name' => 'doctors.destroy',
                            'description' => 'Eliminar doctores'])->assignRole($admin);
        Permission::create(['name' => 'doctors.index.schedule',
                            'description' => 'Gestionar horario de doctores'])->assignRole($admin);
        Permission::create(['name' => 'doctors.store.schedule',
                            'description' => 'Modificar horario de doctores'])->assignRole($admin);

        Permission::create(['name' => 'patients.index',
                            'description' => 'Ver pacientes'])->assignRole($admin);
        Permission::create(['name' => 'patients.show',
                            'description' => 'Ver detalles de pacientes'])->assignRole($admin);
        Permission::create(['name' => 'patients.create',
                            'description' => 'Crear pacientes'])->assignRole($admin);
        Permission::create(['name' => 'patients.edit',
                            'description' => 'Editar pacientes'])->assignRole($admin);
        Permission::create(['name' => 'patients.destroy',
                            'description' => 'Eliminar pacientes'])->assignRole($admin);

        Permission::create(['name' => 'users.index',
                            'description' => 'Ver usuarios'])->assignRole($admin);
        Permission::create(['name' => 'users.edit',
                            'description' => 'Editar usuarios'])->assignRole($admin);
        Permission::create(['name' => 'users.destroy',
                            'description' => 'Eliminar usuarios'])->assignRole($admin);

        Permission::create(['name' => 'roles.index',
                            'description' => 'Ver roles'])->assignRole($admin);
        Permission::create(['name' => 'roles.edit',
                            'description' => 'Editar roles'])->assignRole($admin);

        //Permisos para doctores
        Permission::create(['name' => 'schedules.index',
                            'description' => 'Gestionar horario personal de doctores'])->assignRole($doctor);
        Permission::create(['name' => 'schedules.store',
                            'description' => 'Modificar horario personal de doctores'])->assignRole($doctor);

        //Permisos para pacientes
        Permission::create(['name' => 'appointments.index',
                            'description' => 'Ver horario de citas disponibles'])->assignRole($patient);
        Permission::create(['name' => 'appointments.store',
                            'description' => 'Agendar citas'])->assignRole($patient);


        Permission::create(['name' => 'profiles.index',
                            'description' => 'Ver modulo de editar pacientes'])->assignRole($patient);
        Permission::create(['name' => 'profiles.edit',
                            'description' => 'Modificar modulo de editar pacientes'])->assignRole($patient);



        //Permisos para administradores y doctores
        Permission::create(['name' => 'meetings.confirm',
                            'description' => 'Confirmar citas'])->syncRoles([$admin, $doctor]);
        Permission::create(['name' => 'meetings.attend',
                            'description' => 'Poner citas como atendidas'])->syncRoles([$admin, $doctor]);
    }
}
