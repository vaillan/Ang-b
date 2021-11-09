<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PropertyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
            'Casa',
            'Departamento',
            'Oficina',
            'Terreno',
            'Otros'
        );
        foreach($array as $value) {
            \DB::table('property_types')->insert([
                'property_type' => $value,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
