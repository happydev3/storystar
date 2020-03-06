<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Image;

class FavAuthorStoryPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $story = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request)
    {

        $this->story = $request;

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
        $msg->line('<u>A new story is published by YOUR favorited author, ' . strtoupper($this->story->author_name) . '.</u>');
        $msg->line('Here is the link to read it: ' . route("app-story", ['story_id' => $this->story->story_id]));
        $msg->line('If you enjoy ' . ucfirst($this->story->author_name) . '\'s story, please take the time to rate it, and please consider sharing your thoughts with the author using the comment feature at the bottom of the story. THANK YOU!');
//        $msg->line('<strong>Poster IP : </strong>' . $this->story->poster_ip);
//        $msg->line('<strong>Short Description : </strong>' . $this->story->short_description);
//        $msg->line('<strong>Category : </strong>' . $this->story->category->category_title);
//        $msg->line('<strong>Sub Category : </strong>' . $this->story->subcategory->sub_category_title);
//        $msg->line('<strong>Theme : </strong>' . $this->story->theme->theme_title);
//        $msg->line('<strong>Subject Theme : </strong>' . $this->story->subject->subject_title);
//        $msg->line('<strong>Story : </strong>' . $this->story->the_story);
//
//        if (isset($this->story->image) && !empty($this->story->image)) {
//            $msg->attach(storage_path('story/' . $this->story->image));
//        }

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
