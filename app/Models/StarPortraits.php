<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StarPortraits extends Model
{

    use SoftDeletes;

    protected $table = 'star_portraits';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'right_image', 'center_image', 'left_image', 'created_timestamp', 'updated_timestamp', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


}
