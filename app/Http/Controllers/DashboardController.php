<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\PersonalSalud;
use App\Models\Operador;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\ApiResponse;

class DashboardController extends Controller
{
    use ApiResponse;

    public function stats()
    {
        $hoy = Carbon::today();
        
        // 1. Contadores Totales
        $counts = [
            'pacientes' => Paciente::count(),
            'personal' => PersonalSalud::count(),
            'operadores' => Operador::count(),
            'citas_hoy' => Cita::whereDate('fecha', $hoy)->count(),
        ];

        // 2. Data para Gráfico de Barras (Últimos 3 meses para no sobrecargar, o según pidas)
        $appointments_all = Cita::select('id', 'fecha', 'hora', 'personal_salud_id', 'especialidad_id')
            ->where('fecha', '>=', Carbon::now()->subMonths(3))
            ->get();

        // 3. Data para Gráfico de Pastel (Citas por especialidad)
        $specialties_summary = Especialidad::withCount('citas')
            ->get()
            ->map(function($especialidad) {
                return [
                    'nombre' => $especialidad->especialidad,
                    'count' => $especialidad->citas_count
                ];
            });

        // 4. Alertas de Personal (Médicos por especialidad)
        $staff_by_specialty = Especialidad::withCount('personalSalud')
            ->get()
            ->map(function($especialidad) {
                return [
                    'especialidad' => $especialidad->especialidad,
                    'count' => $especialidad->personal_salud_count
                ];
            });

            // 5. AGREGAR ESTO: Últimos Pacientes registrados
        $recent_patients = Paciente::latest()
            ->take(7) // Traer los últimos 10
            ->get(['id', 'nombre', 'apellido', 'dni', 'tipo_documento', 'telefono']);

        return response()->json([
            'counts' => $counts,
            'appointments_all' => $appointments_all,
            'specialties_summary' => $specialties_summary,
            'staff_by_specialty' => $staff_by_specialty,
            'recent_patients' => $recent_patients
        ]);
    }
}
