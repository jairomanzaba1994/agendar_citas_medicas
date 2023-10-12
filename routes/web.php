<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Models\Specialty;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Ir a la página de inicio
Route::get('/', function () {
    return view('welcome');
});

//Ruta para ir al dashboard
Route::get('/inicio', [AdminController::class, 'index'])->name('admin.index');

//Rutas para especialidades
Route::get('/admin/specialties', [SpecialtyController::class, 'index'])
            ->middleware('can:specialties.index')
            ->name('specialties.index');
Route::get('/admin/specialties/create', [SpecialtyController::class, 'create'])
            ->middleware('can:specialties.create')
            ->name('specialties.create');
Route::post('/admin/specialties', [SpecialtyController::class, 'store'])->name('specialties.store');
Route::get('/admin/specialties/{specialty}', [SpecialtyController::class, 'show'])
            ->middleware('can:specialties.show')
            ->name('specialties.show');
Route::get('/admin/specialties/{specialty}/edit', [SpecialtyController::class, 'edit'])
            ->middleware('can:specialties.edit')
            ->name('specialties.edit');
Route::put('/admin/specialties/{specialty}', [SpecialtyController::class, 'update'])->name('specialties.update');
Route::delete('/admin/specialties/{specialty}', [SpecialtyController::class, 'destroy'])
            ->middleware('can:specialties.destroy')
            ->name('specialties.destroy');

//Rutas para doctores
Route::get('/admin/doctors', [DoctorController::class, 'index'])
            ->middleware('can:doctors.index')
            ->name('doctors.index');
Route::get('/admin/doctors/create', [DoctorController::class, 'create'])
            ->middleware('can:doctors.create')
            ->name('doctors.create');
Route::post('/admin/doctors', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('/admin/doctors/{doctor}', [DoctorController::class, 'show'])
            ->middleware('can:doctors.show')
            ->name('doctors.show');
Route::get('/admin/doctors/{doctor}/edit', [DoctorController::class, 'edit'])
            ->middleware('can:doctors.edit')
            ->name('doctors.edit');
Route::put('/admin/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('/admin/doctors/{doctor}', [DoctorController::class, 'destroy'])
            ->middleware('can:doctors.destroy')
            ->name('doctors.destroy');
Route::get('/admin/doctors/{id}/schedules', [DoctorController::class, 'index_schedule'])
            ->middleware('can:doctors.index.schedule')
            ->name('doctors.index.schedule');
Route::post('/admin/doctors/{id}', [DoctorController::class, 'store_schedule'])
            ->middleware('can:doctors.store.schedule')
            ->name('doctors.store.schedule');

//Rutas para crear pacientes
Route::get('/admin/patients', [PatientController::class, 'index'])
            ->middleware('can:patients.index')
            ->name('patients.index');
Route::get('/admin/patients/create', [PatientController::class, 'create'])
            ->middleware('can:patients.create')
            ->name('patients.create');
Route::post('/admin/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/admin/patients/{patient}', [PatientController::class, 'show'])
            ->middleware('can:patients.show')
            ->name('patients.show');
Route::get('/admin/patients/{patient}/edit', [PatientController::class, 'edit'])
            ->middleware('can:patients.edit')
            ->name('patients.edit');
Route::put('/admin/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/admin/patients/{patient}', [PatientController::class, 'destroy'])
            ->middleware('can:patients.index')
            ->name('patients.destroy');

//Rutas para usuarios
Route::resource('/admin/users', UserController::class)
        ->except('create', 'store', 'show')
        ->middleware('can:users.index')
        ->middleware('can:users.edit')
        ->middleware('can:users.destroy')
        ->names('users');

//Rutas para roles
Route::resource('/admin/roles', RoleController::class)
        ->except('show', 'destroy', 'create', 'store')
        ->middleware('can:roles.index')
        ->middleware('can:roles.edit')
        ->names('roles');

//Rutas para horarios
Route::resource('/doctors/schedules', ScheduleController::class)
        ->only('index', 'store')
        ->middleware('can:schedules.index')
        ->middleware('can:schedules.store')
        ->names('schedules');

//Rutas para agendar citas
Route::resource('/patients/appointments', AppointmentController::class)
        ->only('index', 'store')
        ->middleware('can:appointments.index')
        ->middleware('can:appointments.store')
        ->names('appointments');
Route::get('/especialties/{specialty}/medicos', [AppointmentController::class, 'doctors']);
Route::get('/schedules/horas', [AppointmentController::class, 'hours']);

//Rutas para ver y cancelar citas agendadas de pacientes
//Los 3 usuarios
Route::get('/meetings', [AppointmentController::class, 'meetings_index'])->name('meetings.index');
//Route::get('/appointments/meetings', [AppointmentController::class, 'meetings'])->name('appointments.meetings');
Route::post('/meetings/{id}/cancel', [AppointmentController::class, 'meetings_cancel'])->name('meetings.cancel');
Route::get('/meetings/{id}/cancel', [AppointmentController::class, 'form_cancel'])->name('form.cancel');

Route::get('/appointments/{appointments}', [AppointmentController::class, 'show'])->name('appointments.show');

//Rutas para ver y cancelar citas agendadas de doctores
//Route::get('/doctor/meetings', [AppointmentController::class, 'meetings_index'])->name('meetings.index');
//Usuarios admiistrador y doctor
//--P: Cancel               -Cancel                 -Ver
//--D: Atent.Cancel         -Confirm.Cancel         -Ver
//--A: Atent.Cancel.Ver     -Confirm.Cancel.ver     -Ver
Route::post('/meetings/{id}/confirm', [AppointmentController::class, 'meetings_confirm'])
            ->middleware('can:meetings.confirm')
            ->name('meetings.confirm');
Route::post('/meetings/{id}/attend', [AppointmentController::class, 'meetings_attend'])
            ->middleware('can:meetings.attend')
            ->name('meetings.attend');

//Rutas para perfiles
Route::resource('profiles', ProfileController::class)
            ->only('index', 'edit', 'update')
            ->names('profiles');

Auth::routes();
