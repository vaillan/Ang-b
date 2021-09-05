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
            if($keyTypeRent == 'house') {
                $table = $keyTypeRent;
                $insertColumn = 'house_type';
                $this->insertValuesInTable($table, $insertColumn, $valueTypeRent);
            }
            else if($keyTypeRent == 'departament') {
                $table = $keyTypeRent;
                $insertColumn = 'departament_type';
                $this->insertValuesInTable($table, $insertColumn, $valueTypeRent);
            }
            else if($keyTypeRent == 'office') {
                $table = $keyTypeRent;
                $insertColumn = 'office_type';
                $this->insertValuesInTable($table, $insertColumn, $valueTypeRent);
            }
            else if($keyTypeRent == 'ground') {
                $table = $keyTypeRent;
                $insertColumn = 'ground_type';
                $this->insertValuesInTable($table, $insertColumn, $valueTypeRent);
            }
        }
    }
    function insertValuesInTable($table, $insertColumn, $array) {
        foreach($array as $value) {
            \DB::table($table)->insert([
                $insertColumn => $value,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ]);
        }
    }
}
