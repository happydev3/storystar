<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:users';

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


        \DB::table('users')->delete();

        $oldUsers = \DB::table('new_raters')->get(); // it will get the entire table

        $FinalUserData = [];
        $bar = '';
        $bar = $this->output->createProgressBar(count($oldUsers));

        foreach ($oldUsers as $ou) {
            $ou = (array)$ou;
            $BatchDataForUser = [];

            $BatchDataForUser['user_id'] = $ou['rater_id'];
            $BatchDataForUser['email'] = $ou['rater_email'];

            $BatchDataForUser['dob'] = $ou['rater_dob'];
            $BatchDataForUser['username'] = '';

            if ($ou['rater_gender'] == 'M')
                $BatchDataForUser['gender'] = 'Male';
            else if ($ou['rater_gender'] == 'F')
                $BatchDataForUser['gender'] = 'Female';
            else
                $BatchDataForUser['gender'] = '';


            $BatchDataForUser['address'] = $ou['rater_address'];
            $BatchDataForUser['country'] = $ou['rater_country'];
            $BatchDataForUser['password'] = bcrypt($ou['rater_password']);
            $BatchDataForUser['opassword'] = $ou['rater_password'];
            $BatchDataForUser['story_id'] = "";
            $BatchDataForUser['first_login'] = 1;
            $BatchDataForUser['active'] = $ou['active'];

            // user Image
            if ($ou['rater_image'] == "userdefault.jpg")
                $BatchDataForUser['avatar'] = "";
            else {
                $BatchDataForUser['avatar'] = $ou['rater_image'];
            }

            $BatchDataForUser['profile'] = $ou['rater_profile'];

            //  $BatchDataForUser['user_id'] = $ou['rater_profile'];
            $BatchDataForUser['created_timestamp'] = time();
            $BatchDataForUser['updated_timestamp'] = time();

            //if ($ou['rater_name'] && $ou['rater_email'] && $ou['rater_profile'] && $ou['rater_image'])
            if (($ou['rater_profile'] || $ou['rater_image']))
                $BatchDataForUser['is_profile_complete'] = 1;
            else
                $BatchDataForUser['is_profile_complete'] = 0;


            $countStories = 0;
            $countStories = \DB::table('new_stories')->where("poster_email", "=", $ou['rater_email'])->count(); // it will get the entire table

            if (isset($countStories) && !empty($countStories))
                $BatchDataForUser['is_author'] = 1;
            else
                $BatchDataForUser['is_author'] = 0;

            $BatchDataForUser['name'] = $ou['rater_name'];

            /*
                        $author = "";
                        $author = \DB::table('new_stories')
                            ->orderBy("story_id", "desc")
                            ->where("poster_email", "=", $ou['rater_email'])->first(); // it will get the entire table



                        if ($author) {

                            echo $ou['rater_email'];
                            echo "-->";

                            dd($author->poster_name);


                            if ($author->poster_name)
                                $BatchDataForUser['name'] = $author->poster_name;
                            else
                                $BatchDataForUser['name'] = $ou['rater_name'];
                        } else {
                         }*/


            $bar->advance();


            echo \DB::table('users')->insert($BatchDataForUser);


        }

        // dd($FinalUserData);


        //print_r($BatchDataForUser);


        $bar->finish();


        $this->info("\n" . "Email imported in database completed.");

    }
}
