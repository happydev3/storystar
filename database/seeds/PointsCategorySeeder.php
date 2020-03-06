<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'post_comment',
                'description' => 'Comment Post',
                'points' => 5,
                'is_displayed' => 2,
                'history_display' => 0,
                'display_order' => 1
            ],
            [
                'name' => 'story_commented',
                'description' => 'Comment added on story',
                'points' => 5,
                'is_displayed' => 2,
                'history_display' => 0,
                'display_order' => 2

            ],
            [
                'name' => 'rate_story',
                'description' => 'Rate Story',
                'points' => 5,
                'is_displayed' => 2,
                'history_display' => 0,
                'display_order' => 3
            ],
            [
                'name' => 'story_rated',
                'description' => 'Story is rated',
                'points' => 5,
                'is_displayed' => 2,
                'history_display' => 0,
                'display_order' => 4
            ],
            [
                'name' => 'nominate_story',
                'description' => 'Nominate Story',
                'points' => 10,
                'is_displayed' => 2,
                'history_display' => 0,
                'display_order' => 5
            ],
            [
                'name' => 'story_nominated',
                'description' => 'Story is nominated',
                'points' => 10,
                'is_displayed' => 2,
                'history_display' => 0,
                'display_order' => 6
            ],
            [
                'name' => 'blog_reply',
                'description' => 'Reply On Blog',
                'points' => 5,
                'is_displayed' => 2,
                'history_display' => 0,
                'display_order' => 7
            ],
            [
                'name' => 'gift_given',
                'description' => 'Gift Given',
                'points' => 100,
                'is_displayed' => 0,
                'history_display' => 1,
                'display_order' => 8
            ],
            [
                'name' => 'gift_received',
                'description' => 'Gift Received',
                'points' => 100,
                'is_displayed' => 0,
                'history_display' => 1,
                'display_order' => 9
            ],
            [
                'name' => 'author_month_starred',
                'description' => 'Author Featured for Month',
                'points' => 500,
                'is_displayed' => 2,
                'history_display' => 1,
                'display_order' => 10
            ],
            [
                'name' => 'story_week_starred',
                'description' => 'Story Featured for Week',
                'points' => 100,
                'is_displayed' => 2,
                'history_display' => 1,
                'display_order' => 11
            ],
            [
                'name' => 'story_day_starred',
                'description' => 'Story Featured for Day',
                'points' => 25,
                'is_displayed' => 2,
                'history_display' => 1,
                'display_order' => 12
            ],
            [
                'name' => 'contest',
                'description' => 'Contest Payment',
                'points' => 500,
                'is_displayed' => 2,
                'history_display' => 1,
                'display_order' => 13
            ],
            [
                'name' => 'award',
                'description' => 'Points Awarded (By Admin)',
                'points' => 100,
                'is_displayed' => 1,
                'history_display' => 1,
                'display_order' => 14
            ],
            [
                'name' => 'remove',
                'description' => 'Points Deducted (By Admin)',
                'points' => 100,
                'is_displayed' => 1,
                'history_display' => 1,
                'display_order' => 15
            ],
        ];
        DB::table('points_category')->truncate();
        foreach ($categories as $value) {
            DB::table('points_category')->insert($value);
        }
    }
}


