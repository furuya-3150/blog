<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordResetNotification;

class User extends Authenticatable
{
	use Notifiable;
	protected $fillable = [
		'name', 'email', 'password', 'remember_token'
	];

	protected $hidden = [
		'password', 'remember_token',
	];

	public function sendPasswordResetNotification($token) {
		$this->notify(new PasswordResetNotification($token));
	}
}
