<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailToUserNotification extends Notification
{
    use Queueable;

    public $user = "";
    public $request = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $request)
    {
        //$this->user = $user;
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //$this->user = $user;
        //$this->request = $request;
        return (new MailMessage)
            ->subject($this->request->subject)
            ->line($this->request->emailContent . '.')
            ->salutation("Sincerely,\n\r" . ucfirst(config('app.name')) . " Admin");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
