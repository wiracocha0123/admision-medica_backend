<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StorePersonalSaludRequest;
use App\Http\Requests\UpdatePersonalSaludRequest;
use App\Models\PersonalSalud;
use Illuminate\Http\Request;

class PersonaSaludController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page');
        $perPage = max(1, (int) $request->input('per_page', 15));

        $query = PersonalSalud::with('especialidad')->orderBy('id', 'desc');

        if ($page === 'all') {
            $personalsalud = $query->get();
            return response()->json($personalsalud);
        }

        $personalsalud = $query->paginate($perPage);
        return $this->success($personalsalud);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonalSaludRequest $request)
    {
        $personalsalud = PersonalSalud::create($request->validated());
        return $this->success($personalsalud, 'Personal de salud creado', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $personalsalud = PersonalSalud::with('especialidad')->findOrFail($id);
        return $this->success($personalsalud);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonalSaludRequest $request, $id)
    {
        $personalsalud = PersonalSalud::findOrFail($id);
        $personalsalud->update($request->validated());
        return $this->success($personalsalud, 'Personal de salud actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $personalsalud = PersonalSalud::findOrFail($id);
        $personalsalud->delete();
        return $this->success(null, 'Personal de salud eliminado');
    }
}
