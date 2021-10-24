<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DivisasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $divisas = array('$ MXN','$ USD', '€ EUR');

        foreach ($divisas as $divisaValue) {
            \DB::table('divisas')->insert(
                [
                    'type_divisa' => $divisaValue
                ] 
            );
        }
    }
}
