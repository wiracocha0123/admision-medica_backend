<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'DNI' => 'required|string|min:8|unique:operadores,DNI',
            'email' => 'required|email|unique:users,email',
            'usuario' => 'required|string|unique:operadores,usuario',
            'password' => 'required|string|min:4',
            'horario_mensual' => 'nullable|array',
            'horario_mensual.*.dia_numero' => 'nullable|integer',
            'horario_mensual.*.turno_m' => 'nullable|string',
            'horario_mensual.*.turno_t' => 'nullable|string',
            'horario_mensual.*.turno_n' => 'nullable|string',
            'horario_semanal' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'DNI.required' => 'El DNI es obligatorio.',
            'DNI.min' => 'El DNI debe tener al menos 8 digitos.',
            'DNI.unique' => 'Este DNI ya esta registrado.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo es invalido.',
            'email.unique' => 'Este correo ya esta en uso.',
            'usuario.required' => 'El nombre de usuario es obligatorio.',
            'usuario.unique' => 'Este nombre de usuario ya existe.',
            'password.required' => 'La contrasena es obligatoria.',
            'password.min' => 'La contrasena debe tener al menos 4 caracteres.',
        ];
    }
}