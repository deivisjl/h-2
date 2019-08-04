<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAsociado extends Model
{
    protected $table = 'tipo_asociado';

    protected $fillable = [
        'id','nombre','descuento','pv','dias','orden'
    ];
}
