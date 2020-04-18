<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('activo')->nullable()->default(true);
            $table->string('nombre', 40);
            $table->string('direccion', 300)->nullable();
            $table->timestamps();

            // Relacion
       

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidads');
    }
}
