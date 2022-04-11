<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addressee extends Model {
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'addressees';
	protected $fillable = [
		'name',
		'postal_code',
		'prefectures',
		'municipalities',
		'address',
		'telephone_number',
		'user_id',
		'sum_md5',
		'select'
		];
	public function user() {
		return $this->hasOne('App\user');
	}
}
