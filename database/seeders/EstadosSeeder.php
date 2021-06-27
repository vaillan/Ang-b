<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path('app/json/estados.json'); // /var/www/laravel/app/storage/app/json/filename.json
        $estados = json_decode(file_get_contents($path), true);
  
        foreach ($estados as $value) {
            # code...
            \DB::table('estados')->insert([
                'clave' => $value['clave'],
                'nombre' => $value['nombre'],
                'abrev' => $value['abrev'],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
