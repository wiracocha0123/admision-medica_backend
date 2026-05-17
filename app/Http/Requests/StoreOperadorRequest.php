<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperadorRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() != null;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:operadores,email',
            'usuario' => 'required|string|max:255|unique:operadores,usuario',
            'contraseña' => 'required|string|min:6',
            'DNI' => 'required|string|max:20|unique:operadores,DNI',
            'horario_semanal' => 'nullable|array',
        ];
    }
}
