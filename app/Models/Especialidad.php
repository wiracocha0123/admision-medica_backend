<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cita;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [
        'UPS',
        'especialidad',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'especialidad_id');
    }

    public function personalSalud()
    {
        return $this->hasMany(\App\Models\PersonalSalud::class, 'especialidad_id');
    }
}
