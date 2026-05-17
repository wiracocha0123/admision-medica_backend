<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->index(['fecha', 'operador_id']);
            $table->index('paciente_id');
            $table->index('estado');
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->index('dni');
            $table->index('apellido');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropIndex(['fecha', 'operador_id']);
            $table->dropIndex(['paciente_id']);
            $table->dropIndex(['estado']);
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropIndex(['dni']);
            $table->dropIndex(['apellido']);
            $table->dropIndex(['created_at']);
        });
    }
};
