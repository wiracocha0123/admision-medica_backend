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
        $query = Cita::with(['paciente', 'personalSalud', 'operador', 'especialidad']);
        if ($request->filled('personal_salud_id')) $query->where('personal_salud_id', $request->personal_salud_id);
        if ($request->filled('fecha')) $query->whereDate('fecha', $request->fecha);
        return $this->success($query->orderBy('fecha', 'asc')->orderBy('nro_ticket', 'desc')->paginate(20));
    }

    public function getNextTicket(Request $request)
    {
        if (!$request->filled('fecha')) return $this->success(['next_ticket' => 1]);
        
        // REGLA: Ticket global por fecha (sin filtrar por médico)
        $citas = Cita::whereDate('fecha', $request->fecha)->get();
        $maxTicket = 0;
        foreach ($citas as $c) {
            $numero = (int) $c->nro_ticket;
            if ($numero > $maxTicket) $maxTicket = $numero;
        }
        return $this->success(['next_ticket' => $maxTicket + 1]);
    }

    public function store(StoreCitaRequest $request)
    {
        $data = $request->validated();
        
        // Calcular ticket global antes de insertar
        $citas = Cita::whereDate('fecha', $data['fecha'])->get();
        $maxTicket = 0;
        foreach ($citas as $c) {
            $numero = (int) $c->nro_ticket;
            if ($numero > $maxTicket) $maxTicket = $numero;
        }
        
        $nuevoTicket = $maxTicket + 1;
        $data['nro_ticket'] = $nuevoTicket;
        if (!isset($data['operador_id'])) $data['operador_id'] = auth()->id();
        
        $cita = Cita::create($data);
        return $this->success($cita, 'Ticket #' . $nuevoTicket . ' generado.', 201);
    }

    public function update(UpdateCitaRequest $request, $id)
    {
        $cita = Cita::find($id);
        if (!$cita) return $this->error('No encontrado', 404);
        $cita->update($request->validated());
        return $this->success($cita);
    }

    public function destroy($id)
    {
        $cita = Cita::find($id);
        if (!$cita) return $this->error('No encontrado', 404);
        $cita->delete();
        // Fix: Pasar array para evitar error en ApiResponse trait
        return $this->success(['id' => $id], 'Cita eliminada correctamente');
    }
}