<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Rater;

class UpdateRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "It will clear the request cache table.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //connection('mysql2')->

        ini_set('memory_limit', '-1');

        \DB::table('raters')->delete();

        $bar = '';


        $oldUsers = \DB::table('new_raters')
            ->select([
                'rater_id', 'rated_story_id'
            ])
            ->get();

        $bar = $this->output->createProgressBar(count($oldUsers));

        foreach ($oldUsers as $ou) {

            $bar->advance();

            $ou = (array) $ou;

            if ($ou['rated_story_id']) {
                $storyIds = explode(",", $ou['rated_story_id']);

                foreach ($storyIds as $storyId) {

                    if ($storyId) {
                        $BatchDataForUser = [];
                        $BatchDataForUser['user_id'] = $ou['rater_id'];
                        $BatchDataForUser['story_id'] = $storyId;
                        $BatchDataForUser['rate'] = rand(1, 5);
                        $BatchDataForUser['created_at'] = date('Y-m-d H:i:s');
                        $BatchDataForUser['updated_at'] = date('Y-m-d H:i:s');

                        Rater::insert($BatchDataForUser);
                    }

                }

            }
        }


        $bar->finish();


        $this->info("\n" . " imported in database completed.");


        //  dump($result);
        //new_story_ratings


//
//
//
//        \DB::table('raters')->delete();
//
//        $oldUsers = \DB::table('new_raters')->get(); // it will get the entire table
//
//        $FinalUserData = [];
//        $bar = '';
//        $bar = $this->output->createProgressBar(count($oldUsers));
//
//        foreach ($oldUsers as $ou) {
//            $ou = (array)$ou;
//
//
//
//
//            if ($ou['rated_story_id']) {
//                $storyIds = explode(",", $ou['rated_story_id']);
//
//                foreach ($storyIds as $storyId) {
//
//                    if ($storyId) {
//                        $BatchDataForUser = [];
//                        $BatchDataForUser['user_id'] = $ou['rater_id'];
//                        $BatchDataForUser['story_id'] = $storyId;
//                        $BatchDataForUser['rate'] = rand(1,5);
//                        $BatchDataForUser['created_at'] = date('Y-m-d H:i:s');
//                        $BatchDataForUser['updated_at'] = date('Y-m-d H:i:s');
//
//                        Rater::insert($BatchDataForUser);
//                    }
//
//                }
//
//            }
//
//
//
//
//
//            $bar->advance();
//
//
//        }
//
//        // dd($FinalUserData);
//
//
//        //print_r($BatchDataForUser);
//
//
//        $bar->finish();
//
//
//        $this->info("\n" . "Email imported in database completed.");

    }
}
