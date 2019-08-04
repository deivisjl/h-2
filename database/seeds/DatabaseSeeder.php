<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         $this->call(rol_seeder::class);
         $this->call(usuario_seeder::class);
         $this->call(tipo_asociado_seeder::class);
    }
}
