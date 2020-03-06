<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

        'App\Events\ReceivedApiCall' => [
            'App\Listeners\RequestLogInsertionFired',
        ],
        'App\Events\SaveListViewCall' => [
            'App\Listeners\SaveListViewFired',
        ],

        'App\Events\UpdateStoryViewCall' => [
            'App\Listeners\UpdateStoryViewFired',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
