<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Schedule;
use App\Models\Specialty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Eliminar carpeta profiles
        Storage::deleteDirectory('profiles');
        //Crear carpeta profiles
        Storage::makeDirectory('profiles');

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
