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
        'horario_semanal',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'personal_salud_id');                                 
}   
    
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function horarioSemanal()
    {
        return json_decode($this->horario_semanal, true);
       
    }
}      