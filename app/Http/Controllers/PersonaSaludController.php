<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalSalud;

class PersonaSaludController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personalsalud = PersonalSalud::all();
        return response()->json($personalsalud);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:20|unique:personal_salud',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|unique:personal_salud',
                'especialidad_id' => 'nullable|exists:especialidades,id',
                'horario_semanal' => 'nullable', // quitamos validación json para procesar manualmente
            ]);

            if (isset($validated['horario_semanal']) && is_array($validated['horario_semanal'])) {
                $validated['horario_semanal'] = json_encode($validated['horario_semanal']);
            }
            if (isset($validated['horario_semanal']) && is_object($validated['horario_semanal'])) {
                $validated['horario_semanal'] = json_encode($validated['horario_semanal']);
            }

            $personalsalud = PersonalSalud::create($validated);
            return response()->json($personalsalud, 201);
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
        $personalsalud = PersonalSalud::find($id);
        return response()->json($personalsalud);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:20|unique:personal_salud,id',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|unique:personal_salud,id',
                'especialidad_id' => 'nullable|exists:especialidades,id',
                'horario_semanal' => 'nullable', // quitamos validación json para procesar manualmente
            ]);

            if (isset($validated['horario_semanal']) && is_array($validated['horario_semanal'])) {
                $validated['horario_semanal'] = json_encode($validated['horario_semanal']);
            }
            if (isset($validated['horario_semanal']) && is_object($validated['horario_semanal'])) {
                $validated['horario_semanal'] = json_encode($validated['horario_semanal']);
            }

            $personalsalud = PersonalSalud::find($id);
            $personalsalud->update($validated);
            return response()->json($personalsalud);
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
        $personalsalud = PersonalSalud::find($id);
        $personalsalud->delete();
        return response()->json(null, 204);
    }
}
