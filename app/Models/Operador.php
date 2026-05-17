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
        'DNI',
        'horario_semanal',
        
    ];

    protected $casts = [
        'horario_semanal' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
