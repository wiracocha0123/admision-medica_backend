<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operadores';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'email',
        'usuario',
        'contraseña',
        'DNI',
        'horario_semanal'
    ];

    protected $casts = [
        'horario_semanal' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}