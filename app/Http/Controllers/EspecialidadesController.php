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
        $page = $request->get('page', 1);
        $search = $request->get('search');
        
        // Versión para invalidación masiva controlada
        $version = Cache::get('especialidades_version', 1);
        $cacheKey = "especialidades_v{$version}_page_{$page}_search_{$search}";

        $especialidades = Cache::remember($cacheKey, 3600, function () use ($search) {
            return Especialidad::select('id', 'UPS', 'especialidad')
                ->when($search, function ($query, $search) {
                    return $query->where('especialidad', 'LIKE', "%{$search}%")
                                 ->orWhere('UPS', 'LIKE', "%{$search}%");
                })
                ->orderBy('id', 'asc')
                ->paginate(10)
                ->toArray(); // Almacenamos array para evitar __PHP_Incomplete_Class_Name
        });

        return response()->json($especialidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEspecialidadRequest $request)
    {
        $especialidad = Especialidad::create($request->validated());
        Cache::increment('especialidades_version');
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
        Cache::increment('especialidades_version');
        return $this->success($especialidad, 'Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $especialidad = Especialidad::find($id);
        $especialidad->delete();
        Cache::increment('especialidades_version');
        return response()->json(null, 204);
    }
}
