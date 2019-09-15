<?php

use App\Rol;
use Illuminate\Database\Seeder;

class rol_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::create([
            'nombre' => "Administrador",
            'administra' => 1
        ]);

        Rol::create([
            'nombre' => "Digitador",
            'administra' => 1
        ]);

        Rol::create([
            'nombre' => "Vendedor",
            'administra' => 1
        ]);

        Rol::create([
            'nombre' => "Asociado"
        ]);
    }
}
