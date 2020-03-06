<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{


    protected $table = 'story_ratings';
    protected $primaryKey = 'story_id';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story_id', 'r1', 'r2', 'r3', 'r4', 'r5'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


    public function rate()
    {
        return $this->belongsTo('App\Models\Story', 'story_id');
    }


}
