<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Image;

class StoryRatingNotification extends Notification
{
    use Queueable;

    protected $story = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request, $requestedData)
    {
        $this->story = $request;
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

        $flaggedStoriesList = route("admin-flag-list");
        $flaggedStoryDetail = route('admin-stories-detail', $this->story->story_id);

        $msg = new MailMessage();
        $msg->line(\Auth::user()->name . ' ('.\Auth::user()->email.') has given 1 star to the story <b>' . $this->story->story_title . '</b>.' . '  <br/>');
        $msg->line('To review the story, please click on the link: <br/><a href="' . $flaggedStoryDetail . '">' . $flaggedStoryDetail . '</a><br/>');

     
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
