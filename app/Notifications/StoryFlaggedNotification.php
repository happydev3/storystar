<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Image;

class StoryFlaggedNotification extends Notification
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
        $msg->line(\Auth::user()->name . ' has flagged the story <b>' . $this->story->story_title . '</b>.' . 'The status of the story is changed to "inactive"  <br/>');
        $msg->line('The reason of flagging is: ' . $this->request->flag_for);
        $msg->line('To review the story, please click on the link: <br/><a href="' . $flaggedStoryDetail . '">' . $flaggedStoryDetail . '</a><br/>');
        $msg->line('To view the listing of the flagged stories, please click on the link: <br/><a href="' . $flaggedStoriesList . '">' . $flaggedStoriesList . '</a>');

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
