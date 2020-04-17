<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
          DB::table('departamentos')->insert([
            'nombre'     => 'Tecnologia',
           
        ]);
          DB::table('departamentos')->insert([
            'nombre'     => 'Mercadeo',
           
        ]);
          DB::table('departamentos')->insert([
            'nombre'     => 'Contabilidad',
           
        ]);
          DB::table('departamentos')->insert([
            'nombre'     => 'Operaciones',
           
        ]);
    }
}
