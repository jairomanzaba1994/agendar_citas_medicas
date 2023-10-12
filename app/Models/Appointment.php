<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_date',
        'schedule_time',
        'doctor_id',
        'patient_id',
        'specialty_id',
    ];

    public function specialty() {
        return $this->belongsTo(Specialty::class);
    }

    public function doctor() {
        return $this->belongsTo(User::class);
    }

    public function patient() {
        return $this->belongsTo(User::class);
    }

    public function cancellation() {
        return $this->hasOne(CancelledApointment::class);
    }
}
