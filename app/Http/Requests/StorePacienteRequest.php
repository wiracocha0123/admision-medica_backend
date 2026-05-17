<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
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
            'dni' => 'required|string|max:20|unique:pacientes',
            'HistoriaClinica' => 'nullable|string|unique:pacientes,HistoriaClinica',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:pacientes',
            'direccion' => 'nullable|string|max:50',
            'gestante' => 'nullable|boolean',
        ];
    }
}
