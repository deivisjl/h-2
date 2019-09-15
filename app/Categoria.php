<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentSluggable\Sluggable;
// use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Categoria extends Model
{
	use Sluggable;
	use SluggableScopeHelpers;

    protected $table = 'categoria';

    protected $fillable = [
        'id','nombre','slug'
    ];

 //   public function sluggable(){
    	
	// 	return [
	// 		'slug' => [
	// 			'source' => 'nombre'
	// 		]
	// 	];
	// }

	public function producto()
	{
		return $this->hasMany('App\Producto');
	}
}
