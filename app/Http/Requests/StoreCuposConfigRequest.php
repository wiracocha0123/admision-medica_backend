<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuposConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fecha' => 'required|date_format:Y-m-d|after_or_equal:today',
            'cupos' => 'required|array|min:1',
            'cupos.*' => 'required|integer|min:1|max:100',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es requerida',
            'fecha.date_format' => 'El formato de la fecha debe ser YYYY-MM-DD',
            'fecha.after_or_equal' => 'La fecha no puede ser menor a hoy',
            'cupos.required' => 'Los cupos son requeridos',
            'cupos.array' => 'Los cupos deben ser un objeto',
            'cupos.min' => 'Debe haber al menos una especialidad con cupos configurados',
            'cupos.*.required' => 'El valor de los cupos es requerido',
            'cupos.*.integer' => 'Los cupos deben ser números enteros',
            'cupos.*.min' => 'Los cupos deben ser mayor o igual a 1',
            'cupos.*.max' => 'Los cupos no pueden ser mayor a 100',
        ];
    }
}
