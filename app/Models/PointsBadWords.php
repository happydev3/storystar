<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsBadWords extends Model
{
    protected $table = 'points_bad_words';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'is_active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function getAllActive()
    {
        $words = PointsBadWords::where(['is_active' => 1])->select('title')->get();
        $return = [];
        foreach ($words as $w) {
            $return[] = $w->title;
        }
        return $return;
    }
}
