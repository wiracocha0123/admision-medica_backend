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
    
    public function index()
    {
        $operadores = Operador::orderBy('apellido')->paginate(25);
        return $this->success($operadores);
    }

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
            }

            return $this->success($operador, 'Creado', 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 'Error interno', 500);
        }
    }

    public function show(string $id)
    {
        $operador = Operador::find($id);
        if (!$operador) return $this->error('No encontrado', 404);
        return $this->success($operador);
    }

    public function update(UpdateOperadorRequest $request, string $id)
    {
        $operador = Operador::find($id);
        if (!$operador) return $this->error('No encontrado', 404);
        
        $data = $request->validated();
        $operador->update($data);

        // Sincronizar con el usuario si existe
        if ($operador->user_id) {
            $user = User::find($operador->user_id);
            if ($user) {
                $userData = [
                    'name' => trim($operador->nombre . ' ' . $operador->apellido),
                    'email' => $operador->email
                ];
                if (!empty($data['contraseña']) || !empty($data['password'])) {
                    $userData['password'] = bcrypt($data['contraseña'] ?? $data['password']);
                }
                $user->update($userData);
            }
        }

        return $this->success($operador, 'Actualizado');
    }

    public function destroy(string $id)
    {
        $operador = Operador::find($id);
        if (!$operador) return $this->error('No encontrado', 404);
        $operador->delete();
        return $this->success(['id' => $id], 'Eliminado');
    }
}

