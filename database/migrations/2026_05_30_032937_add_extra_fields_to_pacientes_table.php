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
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('tipo_documento')->default('DNI')->after('apellido');
            $table->string('etapa_vida')->nullable()->after('gestante'); // RN, Niño, Adolescente, Adulto, Adulto mayor, Gestante
            $table->string('detalle_gestante')->nullable()->after('etapa_vida'); // A1, A2, A3
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['tipo_documento', 'etapa_vida', 'detalle_gestante']);
        });
    }
};
