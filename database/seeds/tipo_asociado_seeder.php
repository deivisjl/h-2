<?php

use App\TipoAsociado;
use Illuminate\Database\Seeder;

class tipo_asociado_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAsociado::create([
            'nombre' => "Distribuidor",
            'descuento' => "25",
            'pv' => '0',
            'dias' => '0',
            'orden' => '1',
            'regalia' => '0'
        ]);

        TipoAsociado::create([
            'nombre' => "Consultor mayor",
            'descuento' => "35",
            'pv' => '500',
            'dias' => '30',
            'orden' => '2',
            'regalia' => '0'
        ]);

        TipoAsociado::create([
            'nombre' => "Productor calificado",
            'descuento' => "42",
            'pv' => '2500',
            'dias' => '90',
            'orden' => '3',
            'regalia' => '0'
        ]);

        TipoAsociado::create([
            'nombre' => "Mayorista",
            'descuento' => "50",
            'pv' => '4000',
            'dias' => '365',
            'orden' => '4',
            'regalia' => '1'
        ]);
    }
}
