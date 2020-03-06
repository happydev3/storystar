<?php

namespace App\Models;

use App\Notifications\PointsContestEntryNotification;
use Illuminate\Database\Eloquent\Model;
use App\Models\PointsHistory;

class ContestEntries extends Model
{
    protected $table = 'contest_entries';
    protected $primaryKey = 'id';
    protected $dates = ["created_at", "updated_at"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function enter($r)
    {
        $action = 'contest';

        //Author id can be the user himself or other when nominated by other user
        $authorId = isset($r->author) ? $r->author : \Auth::user()->user_id;

        //User id will serve as 'nominated by person'
        $userId = \Auth::user()->user_id;
        $requiredPoints = PointsCategory::where(['name' => $action])->value('points');
        $currentPoints = \Auth::user()->points;
        $points = $currentPoints >= $requiredPoints ? $requiredPoints : $currentPoints;
        $story = Story::where(['story_id' => $r->story])->first();

        //Making a contest entry
        ContestEntries::insert([
            'user_id' => $authorId,
            'nominated_by' => $userId,
            'story_id' => $r->story,
            'points' => $points,
            'comments' => $r->comments,
            'created_at' => date('Y-m-d G:i:s')
        ]);

        //Deducting point of author or else the nominating person if he is not the author
        if ($userId == $authorId) {
            PointsHistory::addPoints('contest', $r->story, $authorId, $authorId, -$points);
        } else {
            PointsHistory::addPoints('contest', $r->story, $userId, $userId, -$points);
        }

        $notificationData = [
            'user' => \Auth::user()->name,
            'story' => $story->story_title,
        ];
        \Notification::send(Admin::all(), new PointsContestEntryNotification($notificationData));
    }
}
