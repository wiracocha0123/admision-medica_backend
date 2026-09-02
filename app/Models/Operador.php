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
        'horario_mensual',
    ];

    protected $casts = [
        'horario_mensual' => 'array',
    ];

    public static function normalizeHorarioMensual($value): ?array
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $value = $decoded;
            } else {
                return null;
            }
        }

        if (! is_array($value)) {
            return null;
        }

        return array_values(array_map(function ($dia) {
            return [
                'dia_numero' => (int) ($dia['dia_numero'] ?? 0),
                'turno_m' => (string) ($dia['turno_m'] ?? ''),
                'turno_t' => (string) ($dia['turno_t'] ?? ''),
                'turno_n' => (string) ($dia['turno_n'] ?? ''),
            ];
        }, $value));
    }

    public function getHorarioMensualAttribute($value)
    {
        if ($value !== null && $value !== '') {
            return self::normalizeHorarioMensual($value);
        }

        if (isset($this->attributes['horario_semanal'])) {
            return self::normalizeHorarioMensual($this->attributes['horario_semanal']);
        }

        return null;
    }

    public function setHorarioMensualAttribute($value): void
    {
        $normalized = self::normalizeHorarioMensual($value);
        $this->attributes['horario_mensual'] = $normalized !== null ? json_encode($normalized) : null;
    }

    public function getHorarioSemanalAttribute($value)
    {
        return $this->horario_mensual;
    }

    public function setHorarioSemanalAttribute($value): void
    {
        $this->setHorarioMensualAttribute($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}