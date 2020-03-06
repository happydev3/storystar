<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\StoryCategory;
use App\Models\StorySubject;
use App\Models\StoryTheme;

class UpdateStories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:stories';

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


        \DB::table('stories')->delete();
        \DB::table('story_categories')->delete();
        \DB::table('story_subjects')->delete();
        \DB::table('story_themes')->delete();

        $oldStories = \DB::table('new_stories')->get(); // it will get the entire table
        $oldCountStories = \DB::table('new_stories')->count();
        $bar = '';
        $bar = $this->output->createProgressBar(count($oldStories));

        foreach ($oldStories as $ou) {

            $FinalData = [];
            $ou = (array)$ou;


            $Users = \DB::table('users')->where("email", "=", $ou['poster_email'])->first(); // it will get the entire table
            if (isset($Users->user_id) && !empty($Users->user_id)) {


                $FinalData['story_id'] = $ou['story_id'];
                $FinalData['author_name'] = $ou['poster_name'];
                $FinalData['author_country'] = $ou['poster_country'];

                $FinalData['author_dob'] = $ou['poster_dob'];
                $FinalData['author_address'] = $ou['poster_address'];

                if ($ou['poster_gender'] == 'M')
                    $FinalData['author_gender'] = 'Male';
                else if ($ou['poster_gender'] == 'F')
                    $FinalData['author_gender'] = 'Female';
                else
                    $FinalData['author_gender'] = '';


                $FinalData['category_id'] = $ou['category_id'];
                $FinalData['sub_category_id'] = $ou['sub_category_id'];
                $FinalData['theme_id'] = $ou['theme_id'];
                $FinalData['subject_id'] = $ou['subject_id'];


                $FinalData['story_title'] = str_replace("&#039;", "'", $ou['story_title']);
                $FinalData['story_title'] = str_replace("&quot;", '"', $FinalData['story_title']);
                $FinalData['story_title'] = str_replace("&amp;quot;", '"', $FinalData['story_title']);


                $FinalData['short_description'] = str_replace("&#039;", "'", $ou['short_description']);
                $FinalData['short_description'] = str_replace("&quot;", '"', $FinalData['short_description']);
                $FinalData['short_description'] = str_replace("&amp;quot;", '"', $FinalData['short_description']);


                $FinalData['the_story'] = str_replace("&#039;", "'", $ou['the_story']);
                $FinalData['the_story'] = str_replace("&quot;", '"', $FinalData['the_story']);
                $FinalData['the_story'] = str_replace("&amp;quot;", '"', $FinalData['the_story']);


                $FinalData['poster_ip'] = $ou['poster_ip'];
                $FinalData['user_id'] = $Users->user_id;
                $FinalData['status'] = 'Active';//$ou['status'];
                $FinalData['story_code'] = $ou['story_code'];
                $FinalData['views'] = $ou['views'];;
                $FinalData['image'] = isset($ou['image']) && !empty($ou['image']) ? $ou['image'] : '';
                $FinalData['created_timestamp'] = strtotime($ou['post_date']);
                $FinalData['updated_timestamp'] = strtotime($ou['post_date']);

                if ($ou['theme_id'] == 41)
                    $FinalData['self_story'] = 0;
                else
                    $FinalData['self_story'] = 1;

                echo \DB::table('stories')->insert($FinalData);


                $CategoryData = [];
                $CategoryData['created_timestamp'] = time();
                $CategoryData['category_id'] = $ou['category_id'];
                $CategoryData['sub_category_id'] = null;
                $CategoryData['story_id'] = $ou['story_id'];
                $CategoryData['update_by'] = 'client';

                // Insert in  StoryCategory;
                echo StoryCategory::insert($CategoryData);

                $CategoryData = [];
                $CategoryData['created_timestamp'] = time();
                $CategoryData['category_id'] = null;
                $CategoryData['sub_category_id'] = $ou['sub_category_id'];
                $CategoryData['story_id'] = $ou['story_id'];
                $CategoryData['update_by'] = 'client';
                // Insert in  StoryCategory;
                echo StoryCategory::insert($CategoryData);


                $SubjectData = [];
                $SubjectData['created_timestamp'] = time();
                $SubjectData['subject_id'] = $ou['subject_id'];
                $SubjectData['story_id'] = $ou['story_id'];
                $SubjectData['update_by'] = 'client';
                // Insert in  StorySubject;
                echo StorySubject::insert($SubjectData);

                $Data = [];
                $Data['created_timestamp'] = time();
                $Data['theme_id'] = $ou['theme_id'];
                $Data['story_id'] = $ou['story_id'];
                $Data['update_by'] = 'client';
                // Insert in  StoryTheme;
                echo StoryTheme::insert($Data);


            }


            $bar->advance();
        }

        $bar->finish();


        $this->info("\n" . "Stories imported in database completed.");

    }
}
