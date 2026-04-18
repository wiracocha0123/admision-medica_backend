<?php

namespace App\Http\Controllers;
use App\Models\Operador;

use Illuminate\Http\Request;

class OperadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operadores = Operador::all();
        return response()->json($operadores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'email|max:255|unique:operador',
                'usuario' => 'required|string|max:255|unique:operador',
                'contraseña' => 'required|string|min:6',
                'horario_semanal' => 'nullable', // quitamos validación json para procesar manualmente
            ]);

            // Si viene como array, lo convertimos a string JSON
            if (isset($validated['horario_semanal']) && is_array($validated['horario_semanal'])) {
                $validated['horario_semanal'] = json_encode($validated['horario_semanal']);
            }

            $operador = Operador::create($validated);
            return response()->json($operador, 201);
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
        $operador = Operador::find($id);
        return response()->json($operador);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $operador = Operador::find($id);
        $operador->update($request->all());
        return response()->json($operador);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $operador = Operador::find($id);
        $operador->delete();
        return response()->json(null, 204);
    }
}
