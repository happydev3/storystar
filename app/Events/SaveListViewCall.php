<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class SaveListViewCall
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $url_called = '';
    public $view = '';


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request)
    {

        $this->url_called = $request->path();
        if ($request->has('view') == true) {
            $this->view = $request->get('view');
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
