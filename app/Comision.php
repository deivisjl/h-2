<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table = 'comision';

    protected $fillable = [
        'id','asociado_id','pedido_id','patrocinado_id','monto','estado'
    ];

	public function asociado()
	{
		return $this->belongsTo('App\Asociado');
	}

	public function pedido()
	{
		return $this->belongsTo('App\Pedido');
	}
}
