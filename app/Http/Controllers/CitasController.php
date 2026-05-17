<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StoreCitaRequest;
use App\Http\Requests\UpdateCitaRequest;

=======
>>>>>>> 63c6b9e731499fe0c52cc52c76d37b2a0c9b73c1

class CitasController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
<<<<<<< HEAD
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
=======
    public function index()
    {

        $citas = Cita::all();
        return response()->json($citas);
>>>>>>> 63c6b9e731499fe0c52cc52c76d37b2a0c9b73c1
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
<<<<<<< HEAD
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
=======
        try {
            $validated = $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
                'personal_salud_id' => 'required|exists:personal_salud,id',
                'especialidad_id' => 'required|exists:especialidades,id',
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'operador_id' => 'required|exists:operadores,id',
                'observaciones' => 'nullable|string|max:255',
                'estado' => 'required|in:pendiente,completada,cancelada',
            ]);

            $cita = Cita::create($validated);
            return response()->json($cita, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno',
                'error' => $e->getMessage(),
            ], 500);
        }
>>>>>>> 63c6b9e731499fe0c52cc52c76d37b2a0c9b73c1
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
<<<<<<< HEAD
        $cita = Cita::with([
            'paciente:id,nombre,apellido,dni',
            'personalSalud:id,nombres,apellidos',
            'especialidad:id,especialidad,UPS'
        ])->find($id);

        if (! $cita) {
            return $this->error(['message' => 'Cita no encontrada'], 'Not Found', 404);
        }

        return $this->success($cita);
=======
        try {
            $cita = Cita::findOrFail($id);
            return response()->json($cita);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cita no encontrada',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno',
                'error' => $e->getMessage(),
            ], 500);
        }
>>>>>>> 63c6b9e731499fe0c52cc52c76d37b2a0c9b73c1
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCitaRequest $request, string $id)
    {
<<<<<<< HEAD
        $cita = Cita::find($id);
        if (! $cita) {
            return $this->error(['message' => 'Cita no encontrada'], 'Not Found', 404);
        }
        $validated = $request->validated();

        $cita->update($validated);

        return $this->success($cita, 'Actualizado');
=======
        try {
            $cita = Cita::findOrFail($id);
            $validated = $request->validate([
                'fecha_hora' => 'required|date',
                'paciente_id' => 'required|exists:pacientes,id',
                'personal_salud_id' => 'required|exists:personal_salud,id',
                'motivo' => 'nullable|string|max:255',
            ]);
            $cita->update($validated);
            return response()->json($cita);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cita no encontrada',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno',
                'error' => $e->getMessage(),
            ], 500);
        }
>>>>>>> 63c6b9e731499fe0c52cc52c76d37b2a0c9b73c1
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
<<<<<<< HEAD
        $cita = Cita::find($id);
        if (! $cita) {
            return $this->error(['message' => 'Cita no encontrada'], 'Not Found', 404);
        }
        $cita->delete();
        return response()->json(null, 204);
=======
        try {
            $cita = Cita::findOrFail($id);
            $cita->delete();
            return response()->json([
                'message' => 'Cita eliminada correctamente',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cita no encontrada',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno',
                'error' => $e->getMessage(),
            ], 500);
        }
>>>>>>> 63c6b9e731499fe0c52cc52c76d37b2a0c9b73c1
    }
}
