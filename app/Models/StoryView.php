<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class StoryView extends Model
{


    protected $table = 'story_views';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story_id', 'ip', 'created_timestamp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];


}
