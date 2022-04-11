<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Refund extends Notification
{
	use Queueable;
	protected $amount;

	public function __construct($amount)
	{
		$this->amount = $amount;
	}

	public function via($notifiable)
	{
		return ['mail'];
	}

	public function toMail($notifiable)
	{
		return (new MailMessage)
					->line("{$this->amount} を返金しました");
	}

	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
