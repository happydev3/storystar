<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FavoriteAuthor extends Model
{


    protected $table = 'favorite_authors';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'author_id', 'created_timestamp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function stories()
    {
        return $this->hasMany(StoryCategory::class, 'story_id', 'story_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\SiteUser', 'user_id', 'user_id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\SiteUser', 'author_id', 'user_id');
    }

    public function getFavoriteAuthors($data)
    {

        //    \DB::enableQueryLog();

        $this->data = $data;



        $result = FavoriteAuthor::with('author')->where("user_id", "=", $this->data["userID"])
            ->orderBy("favorite_authors.id", $this->data['sortby'])->paginate($this->perPage);


        return $result;

//        dd(
//            \DB::getQueryLog()
//        );
    }


}