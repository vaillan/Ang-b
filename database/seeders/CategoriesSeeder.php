<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $categories = [
        'Gerente',
        'Secretaria de Gerencia',
        'Auxiliar de Arrendamientos',
        'Asesor Comercial',
        'Agente de ventas',
        'Coordinador',
        'Social Media',
        'Atención al cliente',
      ];
      foreach ($categories as $category) {
        \DB::table('categories')->insert(
          [
            'category' => $category,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
          ]
        );
      }
    }
}
