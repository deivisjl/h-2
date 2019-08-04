<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';

    protected $fillable = [
        'id','nombre','pais_id'
    ];

    public function pais()
    {
    	return $this->belongsTo('App\Pais');
    }

    public function municipio()
    {
    	return $this->hasMany('App\Municipio');
    }
}
