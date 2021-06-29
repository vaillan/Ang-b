<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path('app/json/municipios.json'); // /var/www/laravel/app/storage/app/json/filename.json
        $municipios = json_decode(file_get_contents($path), true);

        foreach ($municipios as $value) {
            # code...
            \DB::table('municipios')->insert([
                'estado_id' => $value['estado_id'],
                'clave' => $value['clave'],
                'nombre' => $value['nombre'],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
