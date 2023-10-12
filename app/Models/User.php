<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'ci',
        'type_patient',
        'date_birth',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //Crear un perfil cuando se crea un usuario
    protected static function boot(){
        parent::boot();
        //Asignar perfil al registrar el usuario
        static::created(function($user){
            $user->profile()->create();
        });
    }

    //Relación de uno a uno (user-profile)
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function schedule(){
        return $this->hasMany(Schedule::class);
    }

    public function specialty(){
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }

    public function adminlte_image() {
        if(Auth::user()->profile->photo == null)
        {
            return asset('img/user-default.png');
        }
        else
        {
            return asset('storage/' . Auth::user()->profile->photo);
        }
    }
}
