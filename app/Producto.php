<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';

    protected $fillable = [
        'id','nombre','precio','pv','img_url','descripcion','categoria_id'
    ];

    public function categoria()
    {
    	return $this->belongsTo('App\Categoria');
    }
}
