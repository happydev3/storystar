<?php

namespace App\Models;

use App\Notifications\PointsBadWordNotification;
use function GuzzleHttp\Promise\all;
use Illuminate\Database\Eloquent\Model;
use App\Models\Story;
use App\Models\PointsCategory;
use App\Models\PointsBadWords;
use App\Models\Blogs;
use App\Models\SiteUser as User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class PointsHistory extends Model
{
    protected $table = 'points_history';
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'points_category_id',
        'user_id',
        'given_user_id',
        'action_id',
        'action_type',
        'points'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Function to add 'rate story' points.
     *
     * @param Request $r
     * @return bool
     */
    public static function rateStory($r)
    {
        $userId = \Auth::user()->user_id;
        if ($r['rate'] > 1) {
            self::addPoints('rate_story', $r['story'], $userId, $userId);
        }

        if ($r['rate'] >= 4) {
            //Getting story detail
            $story = Story::where(['story_id' => $r['story']])->first();
            self::addPoints('story_rated', $r['story'], $story->user_id, $userId);
        }
        return true;
    }

    /**
     * Function to add 'nominate story' points.
     *
     * @param Request $r
     * @return bool
     */
    public static function nominateStory($r)
    {
        $userId = \Auth::user()->user_id;

        //Adding user points
        self::addPoints('nominate_story', $r->story_id, $userId, $userId);

        //Adding author points
        $story = Story::where(['story_id' => $r->story_id])->first();
        self::addPoints('story_nominated', $r->story_id, $story->user_id, $userId);

        return true;
    }

    /**
     * Function to add 'post comments' points.
     *
     * @param Request $r
     * @param Integer $commentId
     * @param Integer $storyId
     * @return bool
     */
    public static function postCommentOnStory($r, $commentId, $storyId)
    {
        //Getting story detail
        $story = Story::where(['story_id' => $storyId])->first();

        //Setting user
        $userId = \Auth::user()->user_id;

        //Do nothing if user is commenting on his own story
        if ($userId == $story->user_id) {
            return false;
        }

        //Get bad words and check comment against them for any occurence
        $action = 'post_comment';
        $badWords = PointsBadWords::getAllActive();
        $occurences = '';
        foreach ($badWords as $bw) {
            $occurence = substr_count($r['comment'], $bw);
            if ($occurence) {
                $occurences .= $bw.', ';
            }
        }

        //If there is a bad word in comment, add in pointsOnHold
        //Else Add in the points history and increment user points
        if ($occurences) {
            PointsOnHold::insert([
                'user_id' => $userId,
                'action_id' => $storyId,
                'action_type' => $action,
                'reason' => 'For the use of "'.substr($occurences, 0, -2).'"',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
            $data = [
                'badWord' => $occurences,
                'userName' => \Auth::user()->name,
                'userId' => $userId,
                'item' => 'story',
                'itemId' => $storyId,
                'itemTitle' => $story->story_title
            ];
            \Notification::send(Admin::all(), new PointsBadWordNotification($data));
            return false;
        } else {
            //Adding points for author
            self::addPoints('story_commented', $storyId, $story->user_id, $userId);

            //Adding points for user
            self::addPoints($action, $storyId, $userId, $userId);
            return true;
        }
    }
    
    public static function postCommentReplyOnStory($r, $commentId, $storyId, $userId)
    {
        //Getting story detail
        $story = Story::where(['story_id' => $storyId])->first();

        //if user is replying to comment on his own story
        if ($userId == $story->user_id) {
            self::addPoints('author_comment_reply', $storyId, $userId, $userId);
            //Adding points for author
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Function to add 'post comments' points.
     *
     * @param Request $r
     * @param Integer $commentId
     * @param Integer $blogId
     * @return bool
     */
    public static function postReplyOnBlog($r, $commentId, $blogId)
    {
        //Get bad words and check comment against them for any occurence
        $action = 'blog_reply';
        $badWords = PointsBadWords::getAllActive();
        $occurences = '';
        foreach ($badWords as $bw) {
            $occurence = substr_count($r['comment'], $bw);
            if ($occurence) {
                $occurences .= $bw.', ';
            }
        }

        //If there is a bad word in comment, add in pointsOnHold
        //Else Add in the points history and increment user points
        $userId = \Auth::user()->user_id;
        if ($occurences) {
            PointsOnHold::insert([
                'user_id' => $userId,
                'action_id' => $blogId,
                'action_type' => $action,
                'reason' => 'For the use of "'.substr($occurences, 0, -2).'"',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
            // Send Email to admin
            $blog = Blogs::where(['id' => $blogId])->first();
            $data = [
                'badWord' => $occurences,
                'userName' => \Auth::user()->name,
                'userId' => $userId,
                'item' => 'blog',
                'itemId' => $blogId,
                'itemTitle' => $blog->title
            ];
            \Notification::send(Admin::all(), new PointsBadWordNotification($data));
            return false;
        } else {
            self::addPoints($action, $blogId, $userId, $userId);
            return true;
        }
    }

    /**
     * Function to add 'selected story for day or week' points.
     *
     * @param Request $r
     * @return void
     */
    public static function selectStar($r)
    {
        $userId = \Auth::user()->user_id;
        $story = Story::find($r->story_id);
        \Log::info($story);
        $action = $r->type == 'day' ? 'story_day_starred' : 'story_week_starred';
        self::addPoints($action, $story->story_id, $story->user_id, $userId);
    }

    /**
     * Function to add 'selected author for month' points.
     *
     * @param Request $r
     * @return void
     */
    public static function selectAuthorOfMonth($r)
    {
        $userId = \Auth::user()->user_id;
        $authorId = $r->user_id;
        self::addPoints('author_month_starred', $authorId, $authorId, $userId);
    }

    /**
     * Function to gift points to another user
     *
     * @param Request $r
     * @return void
     */
    public static function gift($r)
    {
        //Giving points to other user
        self::addPoints(
            'gift_received',
            $r->to_user,
            $r->to_user,
            \Auth::user()->user_id,
            $r->points
        );
        //Deducting points from giving user
        self::addPoints(
            'gift_given',
            $r->to_user,
            \Auth::user()->user_id,
            \Auth::user()->user_id,
            -$r->points
        );
    }

    /**
     * Function to add points against different actions.\Auth::user()->user_id
     * This is also used for deduction of points by just passing pointsOverloaded as negative
     *
     * @param String $action
     * @param Integer $actionId
     * @param Integer $userId
     * @param Integer $givenUserId
     * @param Integer $pointsOverloaded
     * @return bool
     */
    public static function addPoints($action, $actionId, $userId, $givenUserId, $pointsOverloaded = '')
    {
        //Step 1
        $pointsDetail = PointsCategory::where(['name' => $action])->first();
        $pointsCategoryId = $pointsDetail->id;
        $points = $pointsOverloaded != '' ? $pointsOverloaded : $pointsDetail->points;
        PointsHistory::insert([
            'points_category_id' => $pointsCategoryId,
            'user_id' => $userId,
            'given_user_id' => $givenUserId,
            'action_id' => $actionId,
            'action_type' => $action,
            'points' => $points,
            'created_at' => date('Y-m-d G:i:s')
        ]);

        //Step 2
        $user = User::find($userId);
        $user->points = $user->points + $points;
        $user->save();
    }

    public static function removePoints($id)
    {
        $point = PointsHistory::find($id);
        //$point->delete();
        $userId = $point->user_id;
        $points = $point->points;
        $user = User::find($userId);
        $user->points = $user->points - $points;
        $user->save();
        self::addPoints('removed', $userId, $userId, \Auth::user()->user_id, '-'.$points);
        return true;
    }

    public static function userHistory($id)
    {
        return PointsCategory::select(
            [
                'points_category.description',
                'points_category.name as type',
                'points_category.history_display',
                \DB::Raw('
                    (CASE
                        WHEN SUM(points_history.points) IS NULL THEN 0
                        ELSE SUM(points_history.points)
                    END)
                        AS points'),
            ]
        )
        ->leftJoin('points_history', function ($join) use ($id) {
            $join->on('points_history.action_type', '=', 'points_category.name')
                ->where('points_history.user_id', "=", $id);
        })
        ->orderBy("points_category.display_order", "asc")
        ->groupBy("points_category.name")
        ->whereNotNull('points_history.points')
        ->get()
        ->toArray();
    }

    public static function userHistoryType($type, $userId)
    {
        $history = PointsHistory::select(
            [
                'points_history.points',
                'points_history.created_at',
                \DB::Raw('
                    (CASE
                        WHEN points_history.action_type = "gift_given" THEN action_user.name
                        WHEN points_history.action_type = "contest" THEN stories.story_title
                        WHEN points_history.action_type = "story_day_starred" THEN stories.story_title
                        WHEN points_history.action_type = "story_week_starred" THEN stories.story_title
                        WHEN users.name IS NOT NULL THEN users.name
                        ELSE backend_user.name
                    END)
                AS element'),
            ]
        )
        ->leftJoin('users', function ($join) {
            $join->on('users.user_id', '=', 'points_history.given_user_id');
        })
        ->leftJoin('users as action_user', function ($join) {
            $join->on('action_user.user_id', '=', 'points_history.action_id');
        })
        ->leftJoin('stories', function ($join) {
            $join->on('stories.story_id', '=', 'points_history.action_id');
        })
        ->leftJoin('backend_user', function ($join) {
            $join->on('backend_user.user_id', '=', 'points_history.given_user_id');
        })
        ->where('points_history.user_id', $userId)
        ->where('points_history.action_type', $type)
        ->orderBy("points_history.id", "desc")
        ->get()
        ->toArray();
        $return = [];
        foreach ($history as $h) {
            $h['created_at'] = date('m/d/Y', strtotime($h['created_at']));
            $return[] = $h;
        }
        return $return;


    }
}
