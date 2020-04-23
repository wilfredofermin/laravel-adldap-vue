<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('solicituds')->insert([
            'Tipo' => '1',
            'serviceskit' => '20205',
            'identidad' => '00112960025',
            'nombres' =>'Antondio A.',
            'apellidos' => 'Gonzalez Perdomo',
            'nombre_completo'=>'Antondio A. Gonzalez Perdomo',
            'departamento' =>'Contabilidad',
            'puesto' => 'cuenta por pagar',
            'localidad' => 'Julio Verne',
            'prioridad' =>'normal',
            'supervisor'     => 'rcontrera@viva.com.do',
            'registrado_por'     => 'uprueba',
            'modificado_por'     => '',
               
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '1',
            'serviceskit' => '20206',
            'identidad' => '00112960026',
            'nombres' =>'Pedro B.',
            'apellidos' => 'Lopez Bermudez',
            'nombre_completo'=>'Antondio A. Gonzalez Perdomo',
            'departamento' =>'Tecnologia',
            'puesto' => 'Programador',
            'localidad' => 'Julio Verne',
            'prioridad' =>'normal',
            'supervisor'     => 'smardonado@viva.com.do',
            'registrado_por'     => 'uprueba',
            'modificado_por'     => '', 
           
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '2',
            'serviceskit' => '20207',
            'identidad' => '00112960027',
            'nombres' =>'Hipolito ',
            'apellidos' => 'Mejia L.',
            'nombre_completo'=>'Hipolito Mejia L.',
            'departamento' =>'Tecnologia',
            'puesto' => 'Programador',
            'localidad' => 'Julio Verne',
            'prioridad' =>'alta',
            'supervisor'     => 'smardonado@viva.com.do',
            'registrado_por'     => 'uprueba',
            'modificado_por'     => '',
            
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '2',
            'serviceskit' => '20208',
            'identidad' => 'fgonzalez',
            'nombres' =>'Wilfred ',
            'apellidos' => 'Contrera Lucas.',
            'nombre_completo'=>'Wilfred Contrera Lucas',
            'departamento' =>'Contabilidad',
            'puesto' => 'Enc. de cobros',
            'localidad' => 'Julio Verne',
            'prioridad' =>'alta',
            'supervisor'     => 'rcontrera@viva.com.do',
            'registrado_por'     => 'wfermin',
            'modificado_por'     => '',
              
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '3',
            'serviceskit' => '20209',
            'identidad' => 'mperez',
            'nombres' =>'Carlos M. ',
            'apellidos' => 'Mejia Lopez.',
            'nombre_completo' => 'Calos M. Mejia Lopez',
            'departamento' =>'Contabilidad',
            'puesto' => 'Enc. de cuesta por pagar',
            'localidad' => 'Julio Verne',
            'prioridad' =>'baja',
            'supervisor'     => 'rcontrera@viva.com.do',
            'registrado_por'     => 'wfermin',
            'modificado_por'     => 'wfermin',
           
        ]);
    }
}
