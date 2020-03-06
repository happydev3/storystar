<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Image;

class StoryPublishedNotification extends Notification
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


        $msg = new MailMessage();

        $msg->line('<u>A new story is published. Here are the details.</u>');
        $msg->line('<strong>Title : </strong>' . '<a  href="' . route("app-story", ['story_id' => $this->story->story_id]) . '">' . $this->story->story_title . '</a>');
        $msg->line('<strong>Short Description : </strong>' . $this->story->short_description);
        $msg->line('<strong>Category : </strong>' . $this->story->category->category_title);
        $msg->line('<strong>Sub Category : </strong>' . $this->story->subcategory->sub_category_title);
        $msg->line('<strong>Theme : </strong>' . $this->story->theme->theme_title);
        $msg->line('<strong>Subject Theme : </strong>' . $this->story->subject->subject_title);
        $msg->line('<strong>Author\'s Name : </strong>' . $this->story->author_name);
        $msg->line('<strong>Author\'s Email : </strong>' . \Auth::user()->email);
        $msg->line('<strong>Story : </strong>' . $this->story->the_story);


        // dd($this->request->story_img);

        if (isset($this->story->image) && !empty($this->story->image)) {
            //$msg->line("<img src='" . Image::url(storage_url($this->story->image, 'story'), 450, 450, array('crop')) . "' />");
            $msg->attach(storage_path('story/' . $this->story->image));
        }

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
