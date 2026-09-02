<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('operadores', 'horario_semanal') && ! Schema::hasColumn('operadores', 'horario_mensual')) {
            Schema::table('operadores', function (Blueprint $table) {
                $table->renameColumn('horario_semanal', 'horario_mensual');
            });
        }

        if (! Schema::hasColumn('operadores', 'horario_mensual')) {
            Schema::table('operadores', function (Blueprint $table) {
                $table->json('horario_mensual')->nullable();
            });
        }

        if (Schema::hasColumn('operadores', 'horario_semanal') && Schema::hasColumn('operadores', 'horario_mensual')) {
            $operadores = DB::table('operadores')->whereNotNull('horario_semanal')->get(['id', 'horario_semanal']);

            foreach ($operadores as $operador) {
                $valor = $operador->horario_semanal;
                $normalizado = is_string($valor) ? json_decode($valor, true) : $valor;

                if (is_array($normalizado)) {
                    DB::table('operadores')->where('id', $operador->id)->update([
                        'horario_mensual' => json_encode($normalizado),
                    ]);
                }
            }

            Schema::table('operadores', function (Blueprint $table) {
                $table->dropColumn('horario_semanal');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('operadores', 'horario_mensual') && ! Schema::hasColumn('operadores', 'horario_semanal')) {
            Schema::table('operadores', function (Blueprint $table) {
                $table->renameColumn('horario_mensual', 'horario_semanal');
            });
        }
    }
};
