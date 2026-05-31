<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StoreEspecialidadRequest;
use App\Http\Requests\UpdateEspecialidadRequest;

class EspecialidadesController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $especialidades = Especialidad::select('id', 'UPS', 'especialidad')
            ->when($search, function ($query, $search) {
                return $query->where('especialidad', 'LIKE', "%{$search}%")
                             ->orWhere('UPS', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return response()->json($especialidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEspecialidadRequest $request)
    {
        $especialidad = Especialidad::create($request->validated());
        return $this->success($especialidad, 'Creado', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $especialidad = Especialidad::find($id);
        return $this->success($especialidad);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEspecialidadRequest $request, string $id)
    {
        $especialidad = Especialidad::find($id);
        $especialidad->update($request->validated());
        return $this->success($especialidad, 'Actualizado');
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
