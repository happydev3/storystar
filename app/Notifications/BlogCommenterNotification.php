<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BlogCommenterNotification extends Notification
{
    use Queueable;

    protected $comment = "";
    protected $blog = "";
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request, $requestedData, $blogRecord)
    {
        //
        $this->comment = $request;
        $this->request = $requestedData;
        $this->blog = $blogRecord;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $blogLink = route('app-blog','admin-blog').'#story-'.$this->blog->id;
        $blogTitle = $this->blog->title;

        $msg = new MailMessage();
        $msg->subject("Blog Comment Notification");
        $msg->line(\Auth::user()->name . ' has posted the following comment on "' . $blogTitle . '" blog:  <br/>');
        $msg->line('"' . $this->comment->comment . '"<br/>');
        $msg->line('To view the Blog, click on <a href="' . $blogLink . '">' . $blogLink . "</a>");

        return $msg;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
