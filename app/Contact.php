<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ContactNotification;

class Contact extends Model
{
	use Notifiable;
	protected $fillable = [
		'name', 'email', 'content', 'user_id', 'payment_id'
	];

	public function payment() {
		return $this->belongsTo('App\Payment', 'payment_id');
	}

	public function contactNotification($data) {
		$this->notify(new ContactNotification($data));
	}
}
