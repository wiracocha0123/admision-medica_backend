<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $citas = Cita::all();
        return response()->json($citas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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
    }
}
