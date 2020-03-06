<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ReceivedApiCall
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $param_string = '';
    public $url_called= '';
    public $app_bundle_id = '';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->param_string= http_build_query($request->input());
        }
        else{
            $this->param_string= http_build_query($request->query());
        }
        $this->url_called = $request->fullUrl();
        $this->app_bundle_id = $request->app_bundle_id;
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
