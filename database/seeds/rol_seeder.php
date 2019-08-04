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
            'nombre' => "Admin"
        ]);

        Rol::create([
            'nombre' => "Digitador"
        ]);

        Rol::create([
            'nombre' => "Asociado"
        ]);
    }
}
