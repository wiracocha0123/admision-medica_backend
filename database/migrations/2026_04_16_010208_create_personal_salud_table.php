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
        Schema::create('personal_salud', function (Blueprint $table) {
            $table->id();
            // Datos Personales
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni', 8)->unique();
            $table->string('telefono', 9)->nullable();
            
            // Autenticación
            $table->string('email')->unique();
            
            // Profesional
            $table->unsignedBigInteger('especialidad_id');
            $table->foreign('especialidad_id')->references('id')->on('especialidades')->onDelete('cascade');
            
            // Horario Semanal (Guardado como JSON)
            // Ejemplo: {"lunes": "08:00-14:00", "martes": "10:00-18:00"...}
            $table->json('horario_semanal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_salud');
    }
};
