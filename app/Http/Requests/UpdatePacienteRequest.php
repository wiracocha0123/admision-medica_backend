<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePacienteRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() != null;
    }

    public function rules()
    {
        $id = $this->route('id') ?? $this->route('paciente');
        return [
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'dni' => "sometimes|string|max:20|unique:pacientes,dni,$id",
            'HistoriaClinica' => "nullable|string|unique:pacientes,HistoriaClinica,$id",
            'telefono' => 'nullable|string|max:20',
            'email' => "nullable|email|max:255|unique:pacientes,email,$id",
            'direccion' => 'nullable|string|max:50',
            'gestante' => 'nullable|boolean',
        ];
    }
}
