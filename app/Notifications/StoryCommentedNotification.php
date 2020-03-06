<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Image;

class StoryCommentedNotification extends Notification
{
    use Queueable;

    protected $story = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request, $requestedData, $storyRecord)
    {
        $this->comment = $request;
        $this->request = $requestedData;
        $this->story = $storyRecord;

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

        $storyLink = route("app-story", ['story_id' => $this->story['story_id']]);

        $msg = new MailMessage();
        $msg->subject("Story Comment Notification");
        $msg->line(\Auth::user()->name . ' has posted the following comment on your story:  <br/>');
        $msg->line('"' . $this->comment->comment . '"<br/>');
        $msg->line('To view the comment, click on <a href="' . $storyLink . '">' . $storyLink . "</a>");

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
