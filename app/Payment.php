<?php

namespace App;

use App\Notifications\Refund;
use App\Notifications\InDelivary;
use App\Notifications\Delivared;
use App\Notifications\SlackNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
	use Notifiable;

	protected $fillable = [
		'payment_code', 'name', 'email', 'total', 'postal_code', 'prefectures', 'municipalities', 'address', 'user_id', 'cart_id', 'in_delivary', 'delivared_at'
	];

	public function cart() {
		return $this->belongsTo('App\Cart', 'cart_id');
	}

	public function refundNotification($amount) {
		$this->notify(new Refund($amount));
	}

	public function inDelivaryNotification($item_name) {
		$this->notify(new InDelivary($item_name));
	}

	public function delivaredNotification($item_name) {
		$this->notify(new Delivared($item_name));
	}

	public function sendSales($sales) {
		$this->notify(new SlackNotification($sales));
	}

	public function routeNotificationForSlack() {
		return env('SLACK_WEBHOOK_URL');
	}
}
