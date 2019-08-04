<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
	protected $table = 'pedido';

    protected $fillable = [
        'id','monto','pv_acumulado','asociado_id','usuario_id','estado','descuento','total','porcentaje'
    ];

	public function asociado()
	{
		return $this->belongsTo('App\Asociado');
	}

	public function users()
	{
		return $this->belongsTo('App\User');
	}
}
