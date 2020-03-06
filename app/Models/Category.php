<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;

    protected $table = 'category_list';
    protected $primaryKey = 'category_id';

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'category_title', 'created_timestamp', 'updated_timestamp','page_title','meta_keywords','meta_description'
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
        return $this->hasMany('App\Models\Story', 'category_id', 'category_id');
    }


}
