<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FavoriteStory extends Model
{


    protected $table = 'favorite_stories';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'story_id', 'created_timestamp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function storycategories()
    {
        return $this->hasMany(StoryCategory::class, 'story_id', 'story_id');
    }

    public function story()
    {
        return $this->belongsTo('App\Models\Story');
    }

}
