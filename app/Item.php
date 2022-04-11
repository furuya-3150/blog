<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $fillable = ['id', 'name', 'image', 'description', 'value', 'stock', 'created_at', 'updated_at', 'deleted_at'];
	protected $table = 'items';

	public function reviews() {
		return $this->hasMany('App\Review');
	}
}
