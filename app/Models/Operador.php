<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    protected $table = 'operadores';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'usuario',
        'contraseña',
        'horario_semanal',
    ];
}
