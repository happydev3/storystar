<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoryStar extends Model
{

    use SoftDeletes;

    protected $table = 'story_star';
    protected $primaryKey = 'storystar_id';

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'category_id', 'sub_category_id', 'story_id', 'date_to', 'date_from', 'type', 'display_type', 'deleted_at', 'created_timestamp', 'updated_timestamp','is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];


    public function story()
    {
        return $this->belongsTo('App\Models\Story', 'story_id');
    }
    public function subcategory()
    {
        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

}
