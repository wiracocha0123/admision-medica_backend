<?php

namespace App\Http\Controllers;
use App\Models\Paciente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiResponse;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;


class PacientesController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page');
        $perPage = max(1, (int) $request->input('per_page', 15));

        $query = Paciente::select(
            'id',
            'nombre',
            'apellido',
            'genero',
            'fecha_nacimiento',
            'dni',
            'tipo_documento',
            'etapa_vida',
            'detalle_gestante',
            'HistoriaClinica',
            'telefono',
            'email',
            'direccion',
            'gestante',
            'estado'
        );
        // --- EL FILTRO QUE SOLICITASTE ---
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        } else {
            // Por defecto, si no se pide nada, mostrar solo Activos
            $query->where('estado', 'Activo');
        }

        $query = $query->orderBy('id', 'desc');

        if ($page === 'all' || $page === '-1') {
            $pacientes = $query->get();
            return response()->json($pacientes);
        }

        $pacientes = $query->paginate($perPage);

        return $this->success($pacientes);
    }

    public function getNextHC()
    {
        // Obtenemos todas las historias que empiecen con H
         $pacientes = Paciente::where('HistoriaClinica', 'LIKE', 'H%')->get(['HistoriaClinica']);
    
    $maxNumber = 0;
    
    foreach ($pacientes as $paciente) {
        // Usamos preg_replace para quedarnos SOLO con los dígitos de 0 a 9
        $number = (int) preg_replace('/[^0-9]/', '', $paciente->HistoriaClinica);
        if ($number > $maxNumber) {
            $maxNumber = $number;
        }
    }

    $nextNumber = $maxNumber + 1;

    return $this->success(['next_hc' => "H-{$nextNumber}"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePacienteRequest $request)
    {
        $paciente = Paciente::create($request->validated());
        return $this->success($paciente, 'Creado', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paciente = Paciente::with(['citas' => function($q){ $q->select('id','paciente_id','fecha','hora','estado'); }])
            ->select('id','nombre','apellido','dni','telefono','email','gestante','direccion','genero','fecha_nacimiento')
            ->find($id);

        return $this->success($paciente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request, string $id)
    {
        $paciente = Paciente::find($id);
        $paciente->update($request->validated());
        return $this->success($paciente, 'Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paciente = Paciente::find($id);
        $paciente->delete();
        return response()->json(null, 204);
    }
}
