<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominatedStory extends Model
{
    protected $table = 'nominated_stories';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'story_id', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}