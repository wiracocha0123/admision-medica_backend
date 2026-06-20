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
        Schema::create('cupos_por_especialidad', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('cascade');
            $table->integer('cantidad_cupos');
            $table->timestamps();
            
            // Índice único para evitar duplicados (una sola configuración por fecha y especialidad)
            $table->unique(['fecha', 'especialidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupos_por_especialidad');
    }
};
