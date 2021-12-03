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
            'English(United States)' => ['English (United States)', 'en-US', 'https://www.sciencekids.co.nz/images/pictures/flags96/United_States.jpg'],
            'Spanish(Spain)' => ['Spanish (Spain)', 'es', 'https://www.sciencekids.co.nz/images/pictures/flags96/Spain.jpg'],
            'French(Standard)' => ['French (Standard)', 'fr', 'https://www.sciencekids.co.nz/images/pictures/flags96/France.jpg']
        );
        foreach ($idiomasArray as $key => $idiomas) {
            \DB::table('idiomas')->insert([
                'lenguage_region_name' => $idiomas[0],
                'iso_code' => $idiomas[1],
                'flag_link' => $idiomas[2],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
