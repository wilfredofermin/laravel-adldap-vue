<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
        Schema::create('users', function (Blueprint $table) {

        $table->bigIncrements('id');
        $table->string('username')->unique();
        $table->string('objectguid')->nullable(); // Added here.
        $table->string('password');
        $table->string('name');
          $table->string('apellidos')->nullable(); 
        $table->string('nombres')->nullable(); 
        $table->string('correo')->nullable(); 
        $table->string('telefono')->nullable(); 
        $table->string('puesto')->nullable(); 
        $table->string('departamento')->nullable(); 
        $table->string('supervisor')->nullable(); 
        $table->string('oficina')->nullable(); 
        $table->string('compania')->nullable(); 
        $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
