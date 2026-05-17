<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCitaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'paciente_id' => 'sometimes|required|exists:pacientes,id',
            'personal_salud_id' => 'nullable|exists:personal_salud,id',
            'especialidad_id' => 'nullable|exists:especialidades,id',
            'fecha' => 'sometimes|required|date',
            'hora' => 'nullable',
            'estado' => 'nullable|string',
            'nro_ticket' => 'sometimes|required|integer',
            'total_tickets_dia' => 'nullable|integer',
            'observaciones' => 'nullable|string',
            'operador_id' => 'nullable|exists:users,id'
        ];
    }
}
