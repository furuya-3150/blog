<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Delivared extends Notification
{
	use Queueable;
	protected $item_name;

    public function __construct($item_name)
	{
		$this->item_name = $item_name;
	}

	public function via($notifiable)
	{
		return ['mail'];
	}

	public function toMail($notifiable)
	{
		return (new MailMessage)
			->line("{$this->item_name} をお届けしました");
	}

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
