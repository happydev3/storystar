<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Image;


class ContactNotification extends Notification
{
    use Queueable;

    protected $story = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($requestedData)
    {
        $this->request = $requestedData;
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


        $msg = new MailMessage();
        $msg->line('<u>You have received a message from StorStar contact page.</u>');
        $msg->line('<strong>Name : </strong>' . $this->request->name);
        $msg->line('<strong>Email : </strong>' . $this->request->email);
        $msg->line('<strong>Subject : </strong>' . $this->request->subject);
        $msg->line('<strong>Message : </strong>' . $this->request->message);
        return $msg;

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
