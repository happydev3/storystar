<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PointsContestEntryNotification extends Notification
{
    use Queueable;

    protected $itemTitle = '';
    protected $userName = '';

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->itemTitle = $data['story'];
        $this->userName = $data['user'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $msg = new MailMessage();
        $subject = 'User  '.$this->userName.' has entered their story "'.$this->itemTitle.'" for contest.';
        $msg->subject($subject);
        $msg->line($subject);
        return $msg;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
