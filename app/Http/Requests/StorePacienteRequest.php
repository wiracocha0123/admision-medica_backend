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
            'nombre' => 'nullable|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'genero' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'tipo_documento' => 'nullable|string|max:50',
            'dni' => 'nullable|string|max:15|unique:pacientes',
            'HistoriaClinica' => 'required|string|unique:pacientes,HistoriaClinica',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:pacientes',
            'direccion' => 'nullable|string|max:100', // Ampliamos un poco por si acaso
            'gestante' => 'nullable|boolean',
            'etapa_vida' => 'nullable|string|max:50',
            'detalle_gestante' => 'nullable|string|max:50',
        ];
    }
}
