<?php

namespace App\Http\Controllers;
use App\Models\Paciente;

use Illuminate\Http\Request;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::all();
        return response()->json($pacientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:pacientes',
            'HistoriaClinica' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:pacientes',
            'sis' => 'nullable|string|max:50',
        ]); 

        $paciente = Paciente::create($request->all());
        return response()->json($paciente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paciente = Paciente::find($id);
        return response()->json($paciente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::find($id);
        $paciente->update($request->all());
        return response()->json($paciente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paciente = Paciente::find($id);
        $paciente->delete();
        return response()->json(null, 204);
    }
}
