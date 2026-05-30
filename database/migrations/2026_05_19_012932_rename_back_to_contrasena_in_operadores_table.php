<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        $cols = DB::getSchemaBuilder()->getColumnListing('operadores');
        $target = null;
        foreach ($cols as $col) {
            if (strpos($col, 'contrase') !== false && $col !== 'contraseña') {
                $target = $col;
                break;
            }
        }
        if ($target) {
            Schema::table('operadores', function (Blueprint $table) use ($target) {
                $table->renameColumn($target, 'contraseña');
            });
        }
    }
    public function down(): void {
        Schema::table('operadores', function (Blueprint $table) {
            $table->renameColumn('contraseña', 'contrasena');
        });
    }
};