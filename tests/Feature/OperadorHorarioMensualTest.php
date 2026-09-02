<?php

namespace Tests\Feature;

use App\Models\Operador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperadorHorarioMensualTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_persists_and_reads_horario_mensual_for_operadores(): void
    {
        $payload = [
            'nombre' => 'Ana',
            'apellido' => 'Gomez',
            'email' => 'ana@example.com',
            'usuario' => 'ana',
            'contraseña' => 'secret123',
            'DNI' => '12345678',
            'horario_mensual' => [
                ['dia_numero' => 1, 'turno_m' => 'AD', 'turno_t' => 'C', 'turno_n' => ''],
                ['dia_numero' => 2, 'turno_m' => '', 'turno_t' => 'V', 'turno_n' => ''],
            ],
        ];

        $operador = Operador::create($payload);

        $this->assertSame($payload['horario_mensual'], $operador->fresh()->horario_mensual);
        $this->assertDatabaseHas('operadores', ['email' => 'ana@example.com']);
    }

    public function test_it_normalizes_legacy_horario_semanal_values(): void
    {
        $operador = Operador::create([
            'nombre' => 'Luis',
            'apellido' => 'Pérez',
            'email' => 'luis@example.com',
            'usuario' => 'luis',
            'contraseña' => 'secret123',
            'DNI' => '87654321',
            'horario_semanal' => json_encode([
                ['dia_numero' => 5, 'turno_m' => 'M', 'turno_t' => '', 'turno_n' => 'N'],
            ]),
        ]);

        $this->assertSame([
            ['dia_numero' => 5, 'turno_m' => 'M', 'turno_t' => '', 'turno_n' => 'N'],
        ], $operador->fresh()->horario_mensual);
    }
}
