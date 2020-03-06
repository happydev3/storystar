<?php

namespace App\Listeners;

use App\Events\ReceivedApiCall;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Requestlogs;

class RequestLogInsertionFired
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
     * @param  ReceivedApiCall $event
     * @return void
     */
    public function handle(ReceivedApiCall $event)
    {

        try {

            $inputs = array();
            $inputs['url_called'] = $event->url_called;
            $inputs['app_bundle_id'] = $event->app_bundle_id;
            $inputs['param_string'] = $event->param_string;
            //   $inputs['create_gmt_date'] = time();
            $inputs['created_timestamp'] = time();
            $inputs['updated_timestamp'] = time();

            Requestlogs::unguard();
            Requestlogs::create($inputs);
            Requestlogs::reguard();

        } catch (\Exception $e) {

            return $e->getMessage();

        }


    }
}
