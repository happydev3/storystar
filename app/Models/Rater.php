<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rater extends Model
{


    protected $table = 'raters';
    protected $primaryKey = 'rater_id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'story_id', 'rate', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


}
