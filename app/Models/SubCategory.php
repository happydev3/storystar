<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{

    use SoftDeletes;

    protected $table = 'sub_category_list';
    protected $primaryKey = 'sub_category_id';

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'sub_category_title','sub_category_title2','sub_category_title3', 'created_timestamp', 'updated_timestamp','page_title','meta_keywords','meta_description'
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
        return $this->hasMany('App\Models\Story', 'sub_category_id', 'sub_category_id');
    }

}
