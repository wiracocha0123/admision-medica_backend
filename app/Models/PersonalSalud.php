<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalSalud extends Model
{
    protected $table = 'personal_salud';

    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'email',
        'especialidad_id',
        'cargo',
        'horario_mensual',
    ];

    protected $casts = [
        'horario_mensual' => 'array',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'personal_salud_id');                                 
}   
    
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'personal_salud_id');
    }

    public function horarioMensual()
    {
        return $this->horario_mensual;
    }
}      