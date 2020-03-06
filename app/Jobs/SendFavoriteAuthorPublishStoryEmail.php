<?php

namespace App\Jobs;

use App\Models\SiteUser;
use Illuminate\Bus\Queueable;
use App\Mail\PublishNewStory;
use App\Notifications\FavAuthorStoryPublishedNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendFavoriteAuthorPublishStoryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lists;
    public $story;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lists, $story)
    {
        $this->lists = $lists;
        $this->story = $story;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //$lists = ['0' => 'faisal@dynamologic.com', '1' => 'faisal.rizwan2004@gmail.com'];

        //config(['queue.default' => 'database']);
        $lists = $this->lists;

        foreach ($lists as $key => $value) {
            $user = SiteUser::find($value);
            $user->notify(new FavAuthorStoryPublishedNotification($this->story));

            Log::info('Email sent: '.$user->email);
            ///Mail::to($value)->queue(new FavAuthorStoryPublishedNotification($this->story));
        }
    }
}
