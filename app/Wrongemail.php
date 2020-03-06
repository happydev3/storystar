<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wrongemail extends Model
{
    protected $dates = ['created_at'];
    protected $fillable = [
        'email', 'problem_type', 'repeated_attempts', 'sub_type'
    ];
}
