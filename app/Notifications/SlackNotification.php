<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class SlackNotification extends Notification
{
	protected $sales;
	protected $channel;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sales)
	{
		$this->channel = env('SLACK_CHANNEL');
		$this->sales = number_format($sales);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSlack($notifiable)
    {
		return (new SlackMessage)
			->from('Laravel')
			->to($this->channel)
			->content('本日の売上は' . $this->sales . '円です');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
