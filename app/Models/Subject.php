<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{

    use SoftDeletes;

    protected $table = 'subjects_list';
    protected $primaryKey = 'subject_id';

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'subject_title', 'created_timestamp', 'updated_timestamp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    /**
     * Get the comments for the blog post.
     */
    public function stories()
    {
        return $this->hasMany('App\Models\Story', 'subject_id', 'subject_id');
    }

}
