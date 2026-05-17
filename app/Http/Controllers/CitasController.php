<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StoreCitaRequest;
use App\Http\Requests\UpdateCitaRequest;


class CitasController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Asegúrate de que los nombres en 'with' coincidan exactamente con los métodos en tu modelo Cita
    $query = Cita::with([
        'paciente:id,nombre,apellido,dni',
        'personalSalud:id,nombres,apellidos', 
        'operador:id,nombre,apellido',
        'especialidad:id,UPS,especialidad'
    ]);

    // Filtro por Médico
    if ($request->filled('personal_salud_id')) {
        $query->where('personal_salud_id', $request->personal_salud_id);
    }

    // Filtro por fecha exacta
    if ($request->filled('fecha')) {
        $query->whereDate('fecha', $request->fecha);
    }

    // Filtros de fecha (Asegúrate que el formato sea Y-m-d)
    if ($request->filled('fecha_from')) {
        $query->whereDate('fecha', '>=', $request->fecha_from);
    }
    if ($request->filled('fecha_to')) {
        $query->whereDate('fecha', '<=', $request->fecha_to);
    }

    // Paginación
    $perPage = (int) $request->input('per_page', 25);
    $citas = $query->orderBy('fecha', 'desc')
                  ->orderBy('hora', 'asc')
                  ->paginate($perPage);

    return $this->success($citas);
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCitaRequest $request)
    {
        $user = $request->user();

        // resolver operador_id: usar el enviado, o si el usuario es operador usar su operador_id
        $opFromRequest = $request->input('operador_id');
        if (empty($opFromRequest) && $user && method_exists($user, 'hasRole') && $user->hasRole('operador')) {
            $opFromRequest = $user->operador_id ?? null;
        }

        $validated = $request->validated();
        $validated['operador_id'] = $opFromRequest;

        // Lógica de autoincremento para nro_ticket si no viene del frontend
        if (!isset($validated['nro_ticket'])) {
            $lastTicket = Cita::where('fecha', $validated['fecha'])
                ->max('nro_ticket');
            $validated['nro_ticket'] = ($lastTicket ?? 0) + 1;
        }

        $cita = Cita::create($validated);

        return $this->success($cita, 'Creado', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Cita::with([
            'paciente:id,nombre,apellido,dni',
            'personalSalud:id,nombres,apellidos',
            'especialidad:id,especialidad,UPS'
        ])->find($id);

        if (! $cita) {
            return $this->error(['message' => 'Cita no encontrada'], 'Not Found', 404);
        }

        return $this->success($cita);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCitaRequest $request, string $id)
    {
        $cita = Cita::find($id);
        if (! $cita) {
            return $this->error(['message' => 'Cita no encontrada'], 'Not Found', 404);
        }
        $validated = $request->validated();

        $cita->update($validated);

        return $this->success($cita, 'Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::find($id);
        if (! $cita) {
            return $this->error(['message' => 'Cita no encontrada'], 'Not Found', 404);
        }
        $cita->delete();
        return response()->json(null, 204);
    }
}
