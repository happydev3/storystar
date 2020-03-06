<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{


    protected $table = 'content';
    protected $primaryKey = 'id';

    protected $dates = ["created_at","updated_at"];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


}
