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
        Schema::table('personal_salud', function (Blueprint $table) {
            $table->renameColumn('horario_semanal', 'horario_mensual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_salud', function (Blueprint $table) {
            $table->renameColumn('horario_mensual', 'horario_semanal');
        });
    }
};
