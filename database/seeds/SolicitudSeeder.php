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
            'cedula' => '00112960025',
            'nombres' =>'Antondio A.',
            'apellidos' => 'Gonzalez Perdomo',
            'departamento' =>'Contabilidad',
            'puesto' => 'cuenta por pagar',
            'localidad' => 'Julio Verne',
            'prioridad' =>'normal',
            'supervisor_email'     => 'rcontrera@viva.com.do',
            'registrado_por'     => 'uprueba',
            'modificado_por'     => '',
               
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '1',
            'serviceskit' => '20206',
            'cedula' => '00112960026',
            'nombres' =>'Pedro B.',
            'apellidos' => 'Lopez Bermudez',
            'departamento' =>'Tecnologia',
            'puesto' => 'Programador',
            'localidad' => 'Julio Verne',
            'prioridad' =>'normal',
            'supervisor_email'     => 'smardonado@viva.com.do',
            'registrado_por'     => 'uprueba',
            'modificado_por'     => '', 
           
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '2',
            'serviceskit' => '20207',
            'nombres' =>'Hipolito ',
            'apellidos' => 'Mejia L.',
            'departamento' =>'Tecnologia',
            'puesto' => 'Programador',
            'localidad' => 'Julio Verne',
            'prioridad' =>'alta',
            'supervisor_email'     => 'smardonado@viva.com.do',
            'registrado_por'     => 'uprueba',
            'modificado_por'     => '',
            
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '2',
            'serviceskit' => '20208',
            // 'username' => '00112960026',
            'nombres' =>'Wilfred ',
            'apellidos' => 'Contrera Lucas.',
            'departamento' =>'Contabilidad',
            'puesto' => 'Enc. de cobros',
            'localidad' => 'Julio Verne',
            'prioridad' =>'alta',
            'supervisor_email'     => 'rcontrera@viva.com.do',
            'registrado_por'     => 'wfermin',
            'modificado_por'     => '',
              
        ]);

         DB::table('solicituds')->insert([
            'Tipo' => '3',
            'serviceskit' => '20209',
            // 'username' => '00112960026',
            'nombres' =>'Carlos M. ',
            'apellidos' => 'Mejia Lopez.',
            'departamento' =>'Contabilidad',
            'puesto' => 'Enc. de cuesta por pagar',
            'localidad' => 'Julio Verne',
            'prioridad' =>'baja',
            'supervisor_email'     => 'rcontrera@viva.com.do',
            'registrado_por'     => 'wfermin',
            'modificado_por'     => 'wfermin',
           
        ]);
    }
}
