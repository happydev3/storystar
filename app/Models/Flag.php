<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{


    protected $table = 'flag_story';
    protected $primaryKey = 'flag_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'story_id', 'messge', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


}
