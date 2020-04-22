<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartamentoSeeder::class);
        $this->call(LocalidadSeeder::class);
        $this->call(SolicitudSeeder::class);
        $this->call(PuestoSeeder::class);
    }
}
