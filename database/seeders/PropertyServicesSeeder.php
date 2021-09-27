<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PropertyServicesSeeder extends Seeder
{   
    public $propertyServiceArray;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    function __construct() {
        $this->propertyServiceArray = array(
            'services' => [
                'Seguridad privada',
                'Calefacción',
                'Área de juegos infantiles',
                'Aire acondicionado',
                'Gimnasio'
            ],
            'general_categories' => [
                'Alberca',
                'Cocina integral',
                'Acceso a discapacitados',
                'Jacuzzi',
                'Mascotas',
                'Caseta de guardia',
                'Cuartos de servicio',
                'Parque',
                'Amueblado',
                'Escuelas cercanas'
            ],
            'exterios' => [
                'Jardin privado',
                'Asador',
                'Cancha de Fútbol',
                'Cancha de Basquetbol',
            ],
            'conservation_state' => [
                'Excelente',
                'Bueno',
                'Regular',
                'Malo',
                'Remodelado',
                'Para remodelar'
            ]
        );
    }

    public function run()
    {
        foreach($this->propertyServiceArray as $keyPropertyService => $valuePropertyService) {
            $table = null;
            $insertColumn = null;
            if($keyPropertyService == 'services') {
                $table = $keyPropertyService;
                $insertColumn = 'service_type';
                $this->insertValuesInTable($table, $insertColumn, $valuePropertyService );
            }else if($keyPropertyService == 'general_categories') {
                $table = $keyPropertyService;
                $insertColumn = 'general_category_type';
                $this->insertValuesInTable($table, $insertColumn, $valuePropertyService );
            }else if($keyPropertyService == 'exteriors') {
                $table = $keyPropertyService;
                $insertColumn = 'exterior_type';
                $this->insertValuesInTable($table, $insertColumn, $valuePropertyService );
            }else if($keyPropertyService == 'conservation_state') {
                $table = $keyPropertyService;
                $insertColumn = 'conservation_state_type';
                $this->insertValuesInTable($table, $insertColumn, $valuePropertyService );
            }
        }
    }

    public function insertValuesInTable($table, $insertColumn, $array) {
        foreach($array as $value) {
            \DB::table($table)->insert([
                $insertColumn => $value,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
