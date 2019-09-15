<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';

    protected $fillable = [
        'id','nombre','administra'
    ];

    public function users()
    {
    	return $this->hasMany('App\User');
    }

}
