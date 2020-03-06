<?php

namespace App\Listeners;

use App\Events\SaveListViewCall;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class SaveListViewFired
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
    public function handle(SaveListViewCall $event)
    {

        try {

            if (in_array($event->view, ['all', 'simple', 'custom'])) {


                $id = Auth::id();
                if ($id):


                    $admin = new Admin();
                    $data = [];
                    $data['ListView'] = [$event->url_called => $event->view];
                    $admin->updateSettingsString($id, $data);

                endif;

            }

        } catch (\Exception $e) {

            return $e->getMessage();

        }


    }
}
