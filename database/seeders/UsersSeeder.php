<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Valentin',
            'last_name' => 'Ortiz',
            'about_me' => 'Ingeniero en Electrónica',
            'role' => 'Empresa',
            'email' => 'ortizsantiago9303@gmail.com',
            'password' => Hash::make('admin00#$'),
            'nick' => 'Val93',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
    }
}
