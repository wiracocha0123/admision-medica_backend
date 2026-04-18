<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'personal_salud_id',
        'especialidad_id',
        'fecha',
        'hora',
        'operador_id',
        'observaciones',
        'estado',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function personalSalud()
    {
        return $this->belongsTo(PersonalSalud::class, 'personal_salud_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }
}
