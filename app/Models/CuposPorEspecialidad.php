<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuposPorEspecialidad extends Model
{
    protected $table = 'cupos_por_especialidad';

    protected $fillable = [
        'fecha',
        'especialidad_id',
        'cantidad_cupos',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cantidad_cupos' => 'integer',
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }
}
