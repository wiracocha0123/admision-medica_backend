<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalSaludRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('personal_salud');
        return [
            'nombres' => 'sometimes|required|string|max:255',
            'apellidos' => 'sometimes|required|string|max:255',
            'dni' => 'sometimes|required|string|max:20|unique:personal_salud,dni,' . $id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:personal_salud,email,' . $id,
            'especialidad_id' => 'nullable|exists:especialidades,id',
            'horario_mensual' => 'nullable|array|min:30|max:31',
            'horario_mensual.*.dia_numero' => 'required|integer',
            'horario_mensual.*.turno_m' => 'nullable|string',
            'horario_mensual.*.turno_t' => 'nullable|string',
            'horario_mensual.*.turno_n' => 'nullable|string',
        ];
    }
}
