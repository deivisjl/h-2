<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedido';

    protected $fillable = [
        'id','pedido_id','producto_id','cantidad','precio','pv','codigo','subtotal'
    ];

	public function pedido()
	{
		return $this->belongsTo('App\Pedido');
	}

	public function producto()
	{
		return $this->belongsTo('App\Producto');
	}
}
