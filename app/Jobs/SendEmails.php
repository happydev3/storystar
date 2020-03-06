<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;


class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $emails;
    protected $template;

    public function __construct($emails,$template)
    {
        $this->emails = $emails;
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET')
            ],
        ]);

        $destinations = [];

        foreach ($this->emails as $email){
            $destinations[]=['Destination' => ['ToAddresses' => [$email],],'ReplacementTemplateData' => '{ }',];
        }

        try {
           
            
            $result = $SesClient->sendBulkTemplatedEmail([
                'Destinations' => $destinations,
                'ReplyToAddresses' => ['"StoryStar" <admin@storystar.com>'],
                'Source' => '"StoryStar" <admin@storystar.com>',
                'Template' => $this->template,
                'DefaultTemplateData' => '{ }',
            ]);

            echo 'success';
            Log::info($result);
            Log::info($destinations);

        } catch (\Aws\Exception\AwsException $e) {
            // output error message if fails
            echo $e->getMessage();
            echo "\n";
        }
    }
}
