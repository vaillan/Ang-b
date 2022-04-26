<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $usersType = [
        'Administrador',
        'Full',
        'Guest',
        'Usuario'
      ];
      foreach ($usersType as $userType) {
        \DB::table('users_type')->insert([
          'role' => $userType,
          'created_at' => date('Y-m-d H:m:s'),
          'updated_at' => date('Y-m-d H:m:s'),
        ]);
      }
    }
}
