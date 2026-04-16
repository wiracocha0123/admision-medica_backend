<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cita;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function citas()
    {
        // return $this->hasMany(Cita::class, 'especialidad_id');
    }
}
