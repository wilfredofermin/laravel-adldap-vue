<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
          DB::table('puestos')->insert([
            'nombre'     => 'Analista Ciberseguridad',
            'departamento_id' => 1,  
        ]);
          DB::table('puestos')->insert([
            'nombre'     => 'Programador',
            'departamento_id' => 1,  
        ]);
          DB::table('puestos')->insert([
            'nombre'     => 'Encargado de Redes',
            'departamento_id' => 1,  
        ]);
          DB::table('puestos')->insert([
            'nombre'     => 'Publicista',
            'departamento_id' => 2,
           
        ]);
          DB::table('puestos')->insert([
            'nombre'     => 'Contable',
            'departamento_id' => 3,
           
        ]);
          DB::table('puestos')->insert([
            'nombre'     => 'Asitente de contabilidad',
            'departamento_id' => 3,
           
        ]);
          DB::table('puestos')->insert([
            'nombre'     => 'Chofer',
            'departamento_id' => 4,
           
        ]);
    }
}
