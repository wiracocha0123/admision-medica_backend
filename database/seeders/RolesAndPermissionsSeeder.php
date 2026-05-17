<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder {
  public function run() {
    $guard = 'api';

    $permissions = [
      'crear citas','ver citas','editar citas','eliminar citas',
      'crear pacientes','ver pacientes','editar pacientes','eliminar pacientes',
      'crear operadores','ver operadores','editar operadores','eliminar operadores',
      'ver personal_salud','crear personal_salud','editar personal_salud','eliminar personal_salud',
      'ver reportes','crear reportes','editar reportes','eliminar reportes'
    ];

    foreach ($permissions as $p) {
      Permission::firstOrCreate(['name' => $p, 'guard_name' => $guard]);
    }

    $operador = Role::firstOrCreate(['name'=>'operador','guard_name'=>$guard]);
    $operador->syncPermissions([
      'crear citas', 'ver citas', 'editar citas', 'eliminar citas',
      'crear pacientes', 'ver pacientes', 'editar pacientes', 'eliminar pacientes',
      'crear operadores', 'ver operadores', 'editar operadores', 'eliminar operadores',
      'ver personal_salud', 'crear personal_salud', 'editar personal_salud', 'eliminar personal_salud',
      'ver reportes', 'crear reportes', 'editar reportes', 'eliminar reportes'
    ]);

    $supervisor = Role::firstOrCreate(['name'=>'supervisor','guard_name'=>$guard]);
    $supervisor->syncPermissions(['ver citas','ver pacientes', 'ver operadores','ver personal_salud', 'crear operadores', 'editar operadores', 'eliminar operadores', 'ver reportes']);
  }
}