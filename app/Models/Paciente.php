<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'genero',
        'fecha_nacimiento',
        'tipo_documento',
        'gestante',
        'etapa_vida',
        'detalle_gestante',
        'dni',
        'HistoriaClinica',
        'telefono',
        'email',
        'direccion',
        'estado',
    ];

    protected $casts = [
        'gestante' => 'boolean',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }
                
}
