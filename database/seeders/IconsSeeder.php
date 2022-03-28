<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $icons = [
        'Alberca' => 'pool',
        'Cocina integral' => 'soup_kitchen',
        'Acceso a discapacitados' => 'accessible_forward',
        'Jacuzzi' => 'hot_tub',
        'Mascotas' => 'pets',
        'Caseta de guardia' => 'local_police',
        'Cuartos de servicio' => 'home_repair_service',
        'Parque' => 'park',
        'Amueblado' => 'weekend',
        'Escuelas cercanas' => 'school',
        'Jardin privado' => 'grass',
        'Asador' => 'outdoor_grill',
        'Cancha de Fútbol' => 'sports_soccer',
        'Cancha de Basquetbol' => 'sports_tennis',
        'Excelente' => 'work_history',
        'Bueno' => 'work_history',
        'Regular' => 'work_history',
        'Malo' => 'work_history',
        'Remodelado' => 'work_history',
        'Para remodelar' => 'work_history',
      ];

      foreach ($icons as $key =>  $icon) {
        \DB::table('general_categories')->where('general_category_type', $key)->update([
          'icon' => $icon,
          'updated_at' => date('Y-m-d H:m:s'),
        ]);

        \DB::table('exteriors')->where('exterior_type', $key)->update([
          'icon' => $icon,
          'updated_at' => date('Y-m-d H:m:s'),
        ]);

        \DB::table('conservation_state')->where('conservation_state_type', $key)->update([
          'icon' => $icon,
          'updated_at' => date('Y-m-d H:m:s'),
        ]);
      }
    }
}
