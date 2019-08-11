<?php

use App\Rol;
use App\User;
use Illuminate\Database\Seeder;

class usuario_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Rol::all();

        foreach ($roles as $rol){
            
            if(strcmp (strtoupper($rol->nombre) , User::USUARIO_ADMINISTRADOR ))
            {
                $this->rolId = $rol->id;
                break;
            }
        }

        User::create([
            'nombres' => "admin",
            'apellidos' => "admin",
            'sexo' => "1",
            'direccion' => "Ciudad",
            'telefono' => "00000000",
            'email' => "admin@gmail.com",
            'password' => bcrypt('12345'),
            'active' => 1,
            'rol_id' => $this->rolId
        ]);
    }
}
