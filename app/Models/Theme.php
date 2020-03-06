<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{

    use SoftDeletes;

    protected $table = 'themes_list';
    protected $primaryKey = 'theme_id';

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'theme_title', 'theme_order', 'theme_image', 'created_timestamp', 'updated_timestamp','theme_class','theme_slug','page_title','meta_keywords','meta_description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


    static public function getSlug($title)
    {
        $title = str_slug($title);
        $userRows = Theme::whereRaw("theme_slug REGEXP '^{$title}(-[0-9]*)?$'")->get();
        $countUser = count($userRows) + 1;

        return ($countUser > 1) ? "{$title}-{$countUser}" : $title;
    }


    /**
     * Get the comments for the blog post.
     */
    public function stories()
    {
        return $this->hasMany('App\Models\Story', 'theme_id', 'theme_id');
    }
}
