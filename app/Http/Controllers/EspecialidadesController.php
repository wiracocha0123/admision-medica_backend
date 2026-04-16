<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;
use Symfony\Component\HttpKernel\HttpCache\Esi;

class EspecialidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Especialidades = Especialidad::all();
        return response()->json($Especialidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $especialidad = Especialidad::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($especialidad, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $especialidad = Especialidad::find($id);
        return response()->json($especialidad);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $especialidad = Especialidad::find($id);
        $especialidad->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($especialidad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $especialidad = Especialidad::find($id);
        $especialidad->delete();

        return response()->json(null, 204);
    }
}
