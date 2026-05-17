<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // add role to users
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->after('password');
        });

        // add user_id to operadores
        Schema::table('operadores', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id');
        });

        // copy operadores into users and link
        $operadores = DB::table('operadores')->get();
        foreach ($operadores as $op) {
            // if user with same email exists, reuse
            $existing = DB::table('users')->where('email', $op->email)->first();
            if (! $existing) {
                $userId = DB::table('users')->insertGetId([
                    'name' => trim($op->nombre . ' ' . $op->apellido),
                    'email' => $op->email,
                    'password' => Hash::make($op->contraseña),
                    'role' => 'operador',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $userId = $existing->id;
                DB::table('users')->where('id', $userId)->update(['role' => $existing->role ?? 'operador']);
            }

            DB::table('operadores')->where('id', $op->id)->update(['user_id' => $userId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // remove user_id from operadores
        Schema::table('operadores', function (Blueprint $table) {
            if (Schema::hasColumn('operadores', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        // remove role from users
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
