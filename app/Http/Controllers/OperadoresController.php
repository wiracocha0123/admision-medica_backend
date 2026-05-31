<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use App\Models\User;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StoreOperadorRequest;
use App\Http\Requests\UpdateOperadorRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OperadoresController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->success(Operador::with('user')->orderBy('id', 'desc')->paginate(10));
    }

    public function store(StoreOperadorRequest $request)
    {
        Log::info('Datos recibidos en store:', $request->all());
        try {
            $data = $request->validated();
            $operador = DB::transaction(function () use ($data) {
                $user = User::create([
                    'name' => $data['nombre'] . ' ' . $data['apellido'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ]);
                $user->assignRole('operador');

                $horario = $data['horario_semanal'] ?? null;
                
                return Operador::create([
                    'user_id' => $user->id,
                    'nombre' => $data['nombre'],
                    'apellido' => $data['apellido'],
                    'DNI' => $data['DNI'],
                    'email' => $data['email'],
                    'usuario' => $data['usuario'],
                    'contraseña' => $data['password'],
                    'horario_semanal' => $horario // Eloquent manejará el cast a JSON sin escapar caracteres
                ]);
            });

            return $this->success($operador->load('user'), 'Operador creado correctamente', 201);
        } catch (\Exception $e) {
            Log::error('Error en store Operador: ' . $e->getMessage());
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(UpdateOperadorRequest $request, $id)
    {
        Log::info('Datos recibidos en update:', $request->all());
        try {
            $data = $request->validated(); 
            $operador = Operador::findOrFail($id);

            DB::transaction(function () use ($data, $operador) {
                $updateData = [
                    'nombre' => $data['nombre'],
                    'apellido' => $data['apellido'],
                    'DNI' => $data['DNI'],
                    'email' => $data['email'],
                    'usuario' => $data['usuario'],
                ];

                if (array_key_exists('horario_semanal', $data)) {
                    $updateData['horario_semanal'] = $data['horario_semanal'];
                }

                if (!empty($data['password'])) {
                    $updateData['contraseña'] = $data['password'];
                }

                $operador->update($updateData);

                if ($operador->user) {
                    $userData = [
                        'name' => $data['nombre'] . ' ' . $data['apellido'],
                        'email' => $data['email'],
                    ];
                    if (!empty($data['password'])) {
                        $userData['password'] = $data['password'];
                    }
                    $operador->user->update($userData);

                    if (! $operador->user->hasRole('operador')) {
                        $operador->user->assignRole('operador');
                    }
                }
            });

            return $this->success($operador->fresh()->load('user'), 'Operador actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error en update Operador: ' . $e->getMessage());
            return $this->error($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $operador = Operador::findOrFail($id);
            DB::transaction(function () use ($operador) {
                $user = $operador->user;
                $operador->delete();
                if ($user) {
                    $user->delete();
                }
            });
            return $this->success(null, 'Operador eliminado correctamente');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}