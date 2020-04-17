<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('localidads')->insert([
            'nombre'     => 'Julio Verne',
            'direccion' =>'Av. 30 de marzo - Oficinas Adminitrativas'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva Winston Churchill',
            'direccion' =>'Av. Winston Churchill esq. Max Henríquez Ureña No. 73, Piantini
                Santo Domingo, República Dominicana'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Plaza Comercial Galería 360',
            'direccion' =>'Av. John F. Kennedy Km. 5½, Sector Arroyo Hondo, Santo Domingo, Distrito Nacion'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda VIVA Herrera',
            'direccion' =>'Plaza Jean Luis, Herrera. Av. Prolongación 27 Febrero. casi esquina Isabel Aguiar.'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda VIVA San Vicente',
            'direccion' =>'Av. San Vicente de Paul No.26 esq. Calle C, próximo a la Av. Mella, Santo Domingo Este.'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda VIVA Independencia',
            'direccion' =>'Av. Independencia Km.7 Residencial Alexandra 1 Local 102 Santo Domingo'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva Ozama',
            'direccion' =>'C/ Jose Cabrera  esq. Sabana Larga #81, Ensanche Ozama
            Horario: de Lunes A viernes de 8:00am a 7;00PM, los sábados de 8:00am a 6:00pm
            Tel. 809-422-5349'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda La Romana',
            'direccion' =>'Ave. Libertad esquina Doctor Gonzalvo, Jumbo La Romana'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva San Pedro de Macorís',
            'direccion' =>'C/ Luis Amiama Tio No. 5 Jumbo San Pedro San Pedro de Macoris ,República Dominicana'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva Bávaro',
            'direccion' =>'Avda. Estados Unidos (Antigua Carretera gorda), Local 21 Plaza Progreso , Friusa Bavaro'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva Higuey',
            'direccion' =>'Ave. José Audilio Santana Esq. Hermanos Goico, antigua Carretera Romana-Higuey.  Multiplaza La sirena, Higuey'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva Hato Mayor',
            'direccion' =>'Calle Horacio Nuñez, esq. Manuel de Jesus Silverio, # 29, Hato Mayor del Rey, RD. (Frente al Centro de capacitación Informática del Indotel y el Agro-Mercado de Inespre)'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva Santiago',
            'direccion' =>'Av. 27 de Febrero esquina Av. Metropolitana.
            Edificio Metropolitano II , primer nivel ( Frente a la plaza el Paseo)  Santiago, República Dominicana'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda Viva Puerto Plata',
            'direccion' =>'C/ Beller , Esquina Padre Castellano No. 53 Puerto Plata, República Dominicana'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda San Francisco de Macorí',
            'direccion' =>'Calle San Francisco Esq. Castillo, Plaza Metropolis Local 1-A San Francisco de Macoris'
        ]);
        DB::table('localidads')->insert([
            'nombre'     => 'Tienda La Vega',
            'direccion' =>'Calle General Juan Rodriguez, Esq. Calle Colón, Plaza Jiminian, La Vega, R.D.'
        ]);
    }
}
