<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Self_;

class SiteUser extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $dates = ['deleted_at','premium_expiry_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'profile',
        'password',
        'active',
        'verify_token',
        'created_timestamp',
        'updated_timestamp',
        'dob',
        'gender',
        'address',
        'country',
        'points',
        'is_profile_complete',
        'last_login_at',
        'last_login_ip',
        'is_author'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    static public function getUsername($firstName, $lastName)
    {
        $username = Str::slug($firstName . "-" . $lastName);
        $userRows = User::whereRaw("username REGEXP '^{$username}(-[0-9]*)?$'")->get();
        $countUser = count($userRows) + 1;

        return ($countUser > 1) ? "{$username}-{$countUser}" : $username;
    }

    public function favoriteauthors()
    {
        return $this->belongsTo('App\Models\FavoriteAuthor', 'user_id', 'author_id');
    }

    public function favoritestories()
    {
        return $this->belongsTo('App\Models\FavoriteStory','user_id');
    }



    public function favorite_authors()
    {
        return $this->hasMany('App\Models\FavoriteAuthor','user_id');
    }

    public function favorite_stories()
    {
        return $this->belongsToMany('App\Models\Story','favorite_stories','user_id','story_id');
    }
    /**
     * Get the comments for the blog post.
     */
    public function stories()
    {
        return $this->hasMany('App\Models\Story', 'user_id', 'user_id');
    }

    public function blogcomment()
    {
        return $this->hasMany('App\Models\BlogComment', 'user_id', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment','user_id','user_id');
    }
    /**
     * Get user Image
     */
    public function getUserImage()
    {
        if ($this->avatar) {
            $image = \Image::url(storage_url($this->avatar, 'users'), 212, 212, array('crop'));
        } else {
            $image = \Image::url(storage_url("default.png", 'users'), 212, 212, array('crop'));
        }
        return $image;
    }

    public static function activeUsersDropdown($isAuthor = false)
    {
        $name = $isAuthor ? "name" : "CONCAT(name, ' - [',email,']') AS name";
        $users = self::select(
            \DB::raw($name),
            'user_id'
        )
        ->orderBy("name", "asc")
        ->where("is_blocked", "=", 0)
        ->where(function ($query) use ($isAuthor) {
            if ($isAuthor) {
                $query->where("is_author", "=", 1);

            }
        })
        ->get()
        ->toArray();
        $return = [];
        foreach ($users as $u) {
            $return[$u['user_id']] = $u['name'];
        }
        return $return;
    }
}
