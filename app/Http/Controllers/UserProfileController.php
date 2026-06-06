<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;

class UserProfileController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/user/profile
     * Obtiene el perfil del usuario autenticado
     */
    public function show(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return $this->error('Usuario no autenticado', 401);
        }

        return $this->success([
            'id' => $user->id,
            'name' => $user->name,
            'apellido' => $user->apellido,
            'email' => $user->email,
            'telefono' => $user->telefono,
        ]);
    }

    /**
     * PUT /api/user/profile
     * Actualiza el perfil del usuario autenticado
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return $this->error('Usuario no autenticado', 401);
        }

        $user->update($request->validated());

        return $this->success([
            'id' => $user->id,
            'name' => $user->name,
            'apellido' => $user->apellido,
            'email' => $user->email,
            'telefono' => $user->telefono,
        ], 'Perfil actualizado correctamente');
    }

    /**
     * POST /api/user/change-password
     * Cambia la contraseña del usuario autenticado
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return $this->error('Usuario no autenticado', 401);
        }

        

        // Actualizar la contraseña
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return $this->success(null, 'Contraseña actualizada correctamente');
    }
}
