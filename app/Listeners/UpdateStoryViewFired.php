<?php

namespace App\Listeners;

use App\Models\StoryView;
use App\Models\Story;

use App\Events\UpdateStoryViewCall;


class UpdateStoryViewFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateStoryViewCall $event
     * @return void
     */
    public function handle(UpdateStoryViewCall $event)
    {
        $story = Story::find($event->story_id);

        if (isset($story) && !empty($story)) {

            $saveNew = false;
            $storyView = StoryView::firstOrNew(array('ip' => $event->ip, 'story_id' => $event->story_id));
            //$storyView = StoryView::firstOrNew(array('story_id' => $event->story_id));

            //if (!isset($storyView->id) || empty($storyView->id)) {
            if (isset($storyView->id) && !empty($storyView->id)) {
                $saveNew = true;
            }

            $storyView->created_timestamp = time();
            $storyView->save();

            if ($saveNew == true) {

                //$allViewsCount = 0;
                // $allViewsCount = StoryView::where('story_id', "=", $event->story_id)->count();


                $story->views = $story->views + 1;
                $story->save();

            }
        }


    }
}
