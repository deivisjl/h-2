<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asociado extends Model
{
	use SoftDeletes;

    protected $table = 'asociado';

    protected $date = ['deleted_at'];

    protected $fillable = [
        'id','sh','nombres','apellidos','dpi','direccion','telefono','correo','tipo_asociado_id','patrocinador_id','pais_id','usuario_id'
    ];

	public function tipo_asociado()
	{
		return $this->belongsTo('App\TipoAsociado');
	}

	public function pais()
	{
		return $this->belongsTo('App\Pais');
	}
}
