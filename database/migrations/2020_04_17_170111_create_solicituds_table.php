<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            //  LOGICA 
            //  Tipo 1 -> ingreso
            //  Tipo 2 -> salida
            //  Tipo 3 -> modificacion

             $table->bigIncrements('id');

            // I ngreso | Salida | Modificacion
            $table->integer('tipo');

            // Esto sera asignado via el controlador via un response recibido por ServicesKit
            $table->integer('serviceskit')->unique();

            // Visible solo para ingreso
            $table->string('identidad')->unique();

            $table->string('nombres',30)->nullable();
            $table->string('apellidos',30)->nullable();
            $table->string('nombre_completo',60);

            $table->string('correo_electronico')->nullable();
            $table->string('telefono',13)->nullable();
            $table->string('nota',300)->nullable();


            $table->string('puesto');
            $table->string('departamento');
            $table->string('localidad');
            
            $table->string('estado')->default("Abierto");
            $table->string('Prioridad');

            // Asignado via el controlador
            $table->string('supervisor')->nullable();

            // Quien registro la solicitud
            $table->string('registrado_por');

            // Usuario que lo medifico | Tomara el usuario quien lo abra despues de creado
            $table->string('modificado_por')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicituds');
    }
}
