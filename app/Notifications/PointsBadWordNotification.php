<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PointsBadWordNotification extends Notification
{
    use Queueable;

    protected $item = '';
    protected $itemId = '';
    protected $itemTitle = '';
    protected $badWord = '';
    protected $userName = '';

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->item = $data['item'];
        $this->itemId = $data['itemId'];
        $this->itemTitle = $data['itemTitle'];
        $this->badWord = $data['badWord'];
        $this->userName = $data['userName'];
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
        $subject = 'User  '.$this->userName.' used a bad word on "'.$this->item.'", '.$this->itemTitle;
        $msg->subject($subject);
        if ($this->item == 'story') {
            $msg->line('<u>Here is the link.</u>');
            $msg->line('<a  href="'.route('app-story', ['story_id' => $this->storyId]).'">'.$this->storyTitle.'</a>');
        } else {
            $msg->line($subject);
        }
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
