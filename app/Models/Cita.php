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
        'nro_ticket',
        'total_tickets_dia',
    ];

    protected $casts = [
        'fecha' => 'date',
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

    public function operador()
    {
        return $this->belongsTo(Operador::class, 'operador_id');
    }
}
