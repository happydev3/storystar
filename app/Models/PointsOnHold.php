<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PointsHistory;

class PointsOnHold extends Model
{
    protected $table = 'points_on_hold';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'points_category_id',
        'user_id',
        'action_id',
        'action_type',
        'is_approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function approve($id)
    {
        //Step 1
        $pointsOnHold = PointsOnHold::find($id);
        $actionType = $pointsOnHold->action_type;
        $userId = $pointsOnHold->user_id;
        $actionId = $pointsOnHold->action_id;
        $pointsOnHold->is_approved = 1;
        $pointsOnHold->save();

        //Step 2 -> Add points for user
        PointsHistory::addPoints($actionType, $id, $userId, \Auth::user()->user_id);

        //Step 3 -> Add points for author
        if ($id = 'post_comment') {
            $story = Story::where(['story_id' => $actionId])->first();
            PointsHistory::addPoints('story_commented', $actionId, $story->user_id, \Auth::user()->user_id);
        }
    }
}
