<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IdiomasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $idiomasArray = array(
            'English(United States)' => ['English (United States)', 'en-US'],
            'Spanish(Spain)' => ['Spanish (Spain)', 'es'],
            'French(Standard)' => ['French (Standard)', 'fr']
        );
        foreach ($idiomasArray as $key => $idiomas) {
            \DB::table('idiomas')->insert([
                'lenguage_region_name' => $idiomas[0],
                'iso_code' => $idiomas[1],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
