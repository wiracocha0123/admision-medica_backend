<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateSupervisorUser extends Seeder {
  public function run() {
    $u = User::firstOrCreate(
      ['email' => 'supervisor@centrosalud.pe'],
      ['name' => 'Supervisor', 'password' => 'SuperPass123']
    );
    $u->assignRole('supervisor');
  }
}