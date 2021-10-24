<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RentaOpcionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rentaOpciones = array(
            'Renta por mes',
            'Renta por noche'
        );

        foreach ($rentaOpciones as $rentaOpcionValue) {
            \DB::table([
                'type_rent_option' => $rentaOpcionValue,
            ]);
        }
    }
}
