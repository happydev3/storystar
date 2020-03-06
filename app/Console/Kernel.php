<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //UpdateTables
        Commands\UpdateTables::class,
        Commands\UpdateStories::class,
        Commands\UpdateRating::class,
        Commands\SendEmails::class,
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

//        $schedule->call(function () {
//            \Log::useFiles(storage_path() . '/logs/email-cron.log');
//            \Log::info("Cron is working  @ " . Carbon::now() . " on " . date(' l'));
//             Artisan::call('send:emails');
//        })->everyMinute()->name('queue-work')->withoutOverlapping();

//        $schedule->call()
        $schedule->command('queue:work --tries=3')->everyMinute()->withoutOverlapping();
        Log::info('Cron hit');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
