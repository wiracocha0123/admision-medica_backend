<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // El parámetro de ruta según artisan route:list es 'operadore'
        $operadorId = $this->route('operadore');
        
        $operador = \App\Models\Operador::find($operadorId);
        $userId = $operador ? $operador->user_id : null;

        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'DNI' => 'required|string|min:8|unique:operadores,DNI,' . ($operadorId ?: 'NULL'),
            'email' => 'required|email|unique:users,email,' . ($userId ?: 'NULL'),
            'usuario' => 'required|string|unique:operadores,usuario,' . ($operadorId ?: 'NULL'),
            'password' => 'nullable|string|min:4',
            'horario_semanal' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'DNI.min' => 'El DNI debe tener por lo menos 8 digitos.',
            'DNI.unique' => 'Este DNI ya esta registrado en otro operador.',
            'email.unique' => 'Este correo ya esta en uso.',
            'usuario.unique' => 'Este nombre de usuario ya esta en uso.',
            'password.min' => 'La contrasena debe tener al menos 4 caracteres.',
        ];
    }
}