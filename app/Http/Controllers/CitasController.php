<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StoreCitaRequest;
use App\Http\Requests\UpdateCitaRequest;

class CitasController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Cita::with(['paciente', 'personalSalud', 'operador', 'especialidad'])
            ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
            ->select('citas.*');

        // Filtro por búsqueda (nombre, apellido, DNI del paciente)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pacientes.nombre', 'like', "%{$search}%")
                  ->orWhere('pacientes.apellido', 'like', "%{$search}%")
                  ->orWhere('pacientes.dni', 'like', "%{$search}%");
            });
        }

        // Filtro por estado (si no es 'todos')
        if ($request->filled('estado') && $request->estado !== 'todos') {
            $query->where('citas.estado', $request->estado);
        }

        // Filtro por especialidad (si no es 'todas')
        if ($request->filled('especialidad_id') && $request->especialidad_id !== 'todas') {
            $query->where('citas.especialidad_id', $request->especialidad_id);
        }

        // Filtros existentes
        if ($request->filled('personal_salud_id')) $query->where('citas.personal_salud_id', $request->personal_salud_id);
        if ($request->filled('fecha')) $query->whereDate('citas.fecha', $request->fecha);

        return $this->success($query->orderBy('citas.fecha', 'asc')->orderBy('citas.nro_ticket', 'desc')->paginate(20));
    }

    public function getNextTicket(Request $request)
    {
        if (!$request->filled('fecha')) {
            return $this->success(['next_ticket' => 1, 'total_tickets_dia' => 16]);
        }

        if (!$request->filled('especialidad_id')) {
            return $this->error('especialidad_id es requerido', 400);
        }

        // Tickets independientes por especialidad y fecha
        $maxTicket = Cita::whereDate('fecha', $request->fecha)
            ->where('especialidad_id', $request->especialidad_id)
            ->max('nro_ticket');

        $cupo = (int) $request->query('cupo', 16);

        return $this->success([
            'next_ticket' => ($maxTicket ?? 0) + 1,
            'total_tickets_dia' => $cupo,
            'especialidad_id' => $request->especialidad_id
        ]);
    }

    public function store(StoreCitaRequest $request)
    {
        $data = $request->validated();

        // Tickets independientes por especialidad y fecha
        $maxTicket = Cita::whereDate('fecha', $data['fecha'])
            ->where('especialidad_id', $data['especialidad_id'])
            ->max('nro_ticket');

        $siguienteTicket = ($maxTicket ?? 0) + 1;

        // Validar cupo máximo
        $cupo = $data['total_tickets_dia'] ?? 16;
        if ($siguienteTicket > $cupo) {
            return $this->error(
                "Se ha alcanzado el cupo máximo ({$cupo}) de tickets para esta especialidad en la fecha {$data['fecha']}.",
                422
            );
        }

        $data['nro_ticket'] = $siguienteTicket;
        if (!isset($data['operador_id'])) {
            $data['operador_id'] = auth('api')->id();
        }

        $cita = Cita::create($data);
        return $this->success($cita, 'Ticket #' . $siguienteTicket . ' generado.', 201);
    }

    public function update(UpdateCitaRequest $request, $id)
    {
        $cita = Cita::find($id);
        if (!$cita) {
            return $this->error('No encontrado', 404);
        }

        $data = $request->validated();

        // Si se actualiza especialidad o fecha, recalcular el ticket
        if ($request->has('especialidad_id') || $request->has('fecha')) {
            $fecha = $request->fecha ?? $cita->fecha;
            $especialidad_id = $request->especialidad_id ?? $cita->especialidad_id;

            // Excluir la cita actual para no contar el mismo ticket
            $maxTicket = Cita::whereDate('fecha', $fecha)
                ->where('especialidad_id', $especialidad_id)
                ->where('id', '!=', $cita->id)
                ->max('nro_ticket');

            $siguienteTicket = ($maxTicket ?? 0) + 1;

            // Validar cupo
            $cupo = $request->total_tickets_dia ?? $cita->total_tickets_dia ?? 16;
            if ($siguienteTicket > $cupo) {
                return $this->error(
                    "Se ha alcanzado el cupo máximo ({$cupo}) de tickets para esta especialidad.",
                    422
                );
            }

            $data['nro_ticket'] = $siguienteTicket;
        }

        $cita->update($data);
        return $this->success($cita, 'Cita actualizada correctamente');
    }

    public function destroy($id)
    {
        $cita = Cita::find($id);
        if (!$cita) {
            return $this->error('No encontrado', 404);
        }

        $cita->delete();
        // Fix: Pasar array para evitar error en ApiResponse trait
        return $this->success(['id' => $id], 'Cita eliminada correctamente');
    }
}