<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path('app/json/LOCALIDADES.json'); // /var/www/laravel/app/storage/app/json/filename.json
        $localidades = json_decode(file_get_contents($path), true);

        foreach ($localidades as $value) {
            # code...
            \DB::table('localidades')->insert([
                'municipio_id' => $value['municipio_id'],
                'clave' => $value['clave'],
                'nombre' => $value['nombre'],
                'lat' => $value['lat'],
                'lng' => $value['lng'],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
