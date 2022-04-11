<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $fillable = [
		'item_id', 'user_id', 'stars', 'comment'
	];

	public function item() {
		return belongsTo('App\item', 'item/id');
	}
}
