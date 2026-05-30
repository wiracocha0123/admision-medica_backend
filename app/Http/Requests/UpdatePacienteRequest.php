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
            'tipo_documento' => 'nullable|string|max:50',
            'dni' => "sometimes|string|max:20|unique:pacientes,dni,$id",
            'HistoriaClinica' => "nullable|string|unique:pacientes,HistoriaClinica,$id",
            'telefono' => 'nullable|string|max:20',
            'email' => "nullable|email|max:255|unique:pacientes,email,$id",
            'direccion' => 'nullable|string|max:100',
            'gestante' => 'nullable|boolean',
            'etapa_vida' => 'nullable|string|max:50',
            'detalle_gestante' => 'nullable|string|max:50',
        ];
    }
}
