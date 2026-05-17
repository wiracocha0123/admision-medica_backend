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
            $table->renameColumn('sis', 'direccion');
        });
        Schema::table('pacientes', function (Blueprint $table) {
        // 2. Cambiar el tipo de dato de boolean a string
        $table->string('direccion')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->renameColumn('direccion', 'sis');
        });
    }
};
