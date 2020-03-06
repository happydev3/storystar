<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class StoryTheme extends Model
{


    protected $table = 'story_themes';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'theme_id', 'story_id', 'created_timestamp', 'update_by'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];



}
