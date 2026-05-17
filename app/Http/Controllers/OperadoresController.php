<?php

namespace App\Http\Controllers;
use App\Models\Operador;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StoreOperadorRequest;
use App\Http\Requests\UpdateOperadorRequest;

class OperadoresController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operadores = Operador::select('id','nombre','apellido','email','usuario','DNI','horario_semanal')
            ->with(['user:id,name,email'])
            ->orderBy('apellido')
            ->paginate(25);

        return $this->success($operadores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOperadorRequest $request)
    {
        try {
            $validated = $request->validated();

            $operador = Operador::create($validated);

            if (!empty($operador->email)) {
                $existing = User::where('email', $operador->email)->first();
                if (!$existing) {
                    $password = $validated['contraseña'] ?? ($validated['password'] ?? 'changeme123');
                    $user = User::create([
                        'name' => trim(($operador->nombre ?? '') . ' ' . ($operador->apellido ?? '')),
                        'email' => $operador->email,
                        'password' => bcrypt($password),
                    ]);
                } else {
                    $user = $existing;
                }

                $operador->user_id = $user->id;
                $operador->save();

                if (method_exists($user, 'hasRole')) {
                    try {
                        if (! $user->hasRole('operador')) {
                            $user->assignRole('operador');
                        }
                    } catch (\Exception $e) {
                        // ignore
                    }
                }
            }

            return $this->success($operador, 'Creado', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error($e->errors(), 'Error de validación', 422);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 'Error interno', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $operador = Operador::with('user')->find($id);
        return $this->success($operador);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperadorRequest $request, string $id)
    {
        $operador = Operador::find($id);
        $operador->update($request->validated());
        return $this->success($operador, 'Actualizado');
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
