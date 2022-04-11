<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactNotification extends Notification
{
	use Queueable;
	protected $data;

    public function __construct($data)
	{
		$this->data = $data;
	}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
	{
		return (new MailMessage)
			->subject('自動送信メール')
			->view('mail.contactEmail', ['data' => $this->data]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
