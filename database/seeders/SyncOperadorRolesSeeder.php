<?php

namespace Database\Seeders;

use App\Models\Operador;
use Illuminate\Database\Seeder;

class SyncOperadorRolesSeeder extends Seeder
{
    public function run(): void
    {
        Operador::with('user')->get()->each(function (Operador $operador) {
            if ($operador->user && ! $operador->user->hasRole('operador')) {
                $operador->user->assignRole('operador');
            }
        });
    }
}
