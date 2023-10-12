<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'utlvtesedesantodomingo@gmail.com',
            'ci' => '1741345687',
            'type_patient' => null,
            'phone' => '0981234567',
            'date_birth' => '1998-07-19',
            'password' => Hash::make("12345678"),
        ])->assignRole('Administrador');
    }
}
