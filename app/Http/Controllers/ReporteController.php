<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ApiResponse;
use App\Models\Paciente;
use App\Models\PersonalSalud;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReporteController extends Controller
{
    use ApiResponse;

    /**
     * Mostrar lista de personal de salud con su especialidad y conteo de pacientes.
     */
    public function index(Request $request)
    {
        try {
            // 1. Usamos select para asegurar que traemos las columnas del personal
            // 2. Cargamos la relación 'especialidad' incluyendo el campo UPS de su tabla
            // 3. Calculamos pacientes únicos mediante una subconsulta de citas
            $list = PersonalSalud::with('especialidad:id,especialidad,UPS')
                ->select('id', 'nombres', 'apellidos', 'especialidad_id')
                ->addSelect(['pacientes_count' => function ($query) {
                    $query->selectRaw('count(distinct paciente_id)')
                        ->from('citas')
                        ->whereColumn('personal_salud_id', 'personal_salud.id');
                }])
                ->orderByDesc('pacientes_count')
                ->paginate(10);

            return $this->success($list);

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error al generar el reporte',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Devuelve los pacientes asociados a un personal de salud con paginación.
     */
    public function showPacientes(Request $request, $id)
    {
        try {
            $personal = PersonalSalud::with('especialidad:id,especialidad,UPS')->find($id);
            
            if (!$personal) {
                return $this->error(null, 'Personal no encontrado', Response::HTTP_NOT_FOUND);
            }

            // Usamos whereHas para una consulta más limpia y eficiente
            // Especificamos 'pacientes' en el orderBy para evitar ambigüedad SQL (Column 'id' is ambiguous)
            $pacientes = Paciente::whereHas('citas', function ($q) use ($id) {
                $q->where('personal_salud_id', $id);
            })
            ->orderBy('pacientes.apellido')
            ->orderBy('pacientes.nombre')
            ->paginate(10);

            // Retornamos la data del personal y la lista paginada de sus pacientes
            return $this->success([
                'personal' => [
                    'id' => $personal->id,
                    'nombres' => $personal->nombres,
                    'apellidos' => $personal->apellidos,
                    'especialidad' => $personal->especialidad?->especialidad,
                    'UPS' => $personal->especialidad?->UPS,
                ],
                'pacientes' => $pacientes
            ]);

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Error al obtener pacientes del personal',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
