<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperadorRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() != null;
    }

    public function rules()
    {
        $id = $this->route('id') ?? $this->route('operador');
        return [
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'email' => "nullable|email|max:255|unique:operadores,email,$id",
            'usuario' => "sometimes|string|max:255|unique:operadores,usuario,$id",
            'contraseña' => 'sometimes|string|min:6',
            'DNI' => "sometimes|string|max:20|unique:operadores,DNI,$id",
            'horario_semanal' => 'nullable|array',
        ];
    }
}
