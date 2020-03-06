<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryLikeRates extends Model
{


    protected $table = 'story_like_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story_id', 'ip_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];




}
