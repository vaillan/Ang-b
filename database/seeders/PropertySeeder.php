<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $property_type = null;
        $typeRentsArray = array( 
            'house' =>
            [
                'Casa unifamiliar',
                'Casa semi-adosada',
                'Casa adosada',
                'Casa tipo dúplex',
                'Casa tipo triplex',
                'Casa de playa',
                'Casa tipo finca'
            ],
            'departament' => 
            [
                'Departamento tipo estudio',
                'Departamento tipo estudio convertible',
                'Dpartamento loft',
                'Departamento tipo duplex',
                'Departamento tipo treplex',
                'Departamento de campo',
                'Departamento de playa',
                'Departamaneto PentHouse',
            ],
            'office' => 
            [
                'Oficina compartida',
                'Oficina virtual',
                'Oficinas ejecutivas',
            ],
            'ground' => 
            [
                'Terreno/lote',
                'Terreno comercial',
                'Terreno industrial',
            ]

        );
        foreach($typeRentsArray as $keyTypeRent => $valueTypeRent) {
            switch ($keyTypeRent) {
                case 'house':
                    $property_type = $this->getPropertyByType('Casa');
                    $table = $keyTypeRent;
                    $insertColumn = 'house_type';
                    $this->insertValuesInTable($table, $insertColumn, $valueTypeRent, $property_type->id);
                break;
                case 'departament':
                    $property_type = $this->getPropertyByType('Departamento');
                    $table = $keyTypeRent;
                    $insertColumn = 'departament_type';
                    $this->insertValuesInTable($table, $insertColumn, $valueTypeRent, $property_type->id);
                break;
                case 'office':
                    $property_type = $this->getPropertyByType('Oficina');
                    $table = $keyTypeRent;
                    $insertColumn = 'office_type';
                    $this->insertValuesInTable($table, $insertColumn, $valueTypeRent, $property_type->id);
                break;
                case 'ground':
                    $property_type = $this->getPropertyByType('Terreno');
                    $table = $keyTypeRent;
                    $insertColumn = 'ground_type';
                    $this->insertValuesInTable($table, $insertColumn, $valueTypeRent, $property_type->id);
                break;

            }
        }
    }

    public function insertValuesInTable($table, $insertColumn, $array, $property_type_id) {
        foreach($array as $value) {
            \DB::table($table)->insert([
                'property_type_id' => $property_type_id,
                $insertColumn => $value,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }

    public function getPropertyByType($property_type) {
        $propertyBytype = \DB::table('property_types')->where('property_type', $property_type)->first();
        return $propertyBytype;
    }
}
