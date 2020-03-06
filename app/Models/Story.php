<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Rater;

class Story extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'stories';
    protected $primaryKey = 'story_id';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $data = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'theme_id',
        'subject_id',
        'story_title',
        'short_description',
        'the_story',
        'poster_ip',
        'status',
        'story_code',
        'image',
        'views',
        'deleted_at',
        'created_timestamp',
        'updated_timestamp',
        'user_id',
        'written_by',
        'author_name',
        'author_country',
        'author_gender',
        'author_dob',
        'author_address',
        'self_story'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Models\SiteUser', 'user_id')->withTrashed();
    }

    public function theme()
    {
        return $this->belongsTo('App\Models\Theme', 'theme_id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    public function rate()
    {
        return $this->belongsTo('App\Models\Rating', 'story_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function favstories()
    {
        return $this->hasMany('App\Models\FavoriteStory', 'story_id', 'story_id');
    }

    public function nominatedstories()
    {
        return $this->hasMany('App\Models\NominatedStory', 'story_id', 'story_id');
    }

    public function storycategories()
    {
        return $this->belongsTo('App\Models\StoryCategory', 'story_id', 'story_id');
    }

    public function favoritestories()
    {
        return $this->belongsTo('App\Models\FavoriteStory', 'story_id', 'story_id');
    }

    public function rater($userID, $storyID)
    {
        return Rater:: where("user_id", "=", $userID)->where("story_id", "=", $storyID)->first();
    }

    public function story_rating(){
        return $this->hasOne('App\Models\Rating','story_id','story_id');
    }

    public function getStories($data)
    {
        \DB::enableQueryLog();
        $this->data = $data;
        if (!empty($this->data['segment']) && ($this->data['segment'] == "read-short-stories")) {
            $result = Story::select("stories.*")
                ->where([["status", "=", "Active"], ["stories.subject_id", "<>", "177"]]);
        } elseif (!empty($this->data['segment']) && ($this->data['segment'] == "story-subject")) {
            $result = Story::select("stories.*")
                ->where([["status", "=", "Active"], ["stories.subject_id", "=", "177"]]);
        } else {
            $result = Story::select("stories.*")->where("status", "=", "Active");
        }

        // users join
        $result = $result->leftJoin('users', function ($join) {
            $join->on('users.user_id', '=', 'stories.user_id');
            // ->whereNull('users.deleted_at')
            //   ->where('active', "=", 1);
        });

        // story_ratings join
        $result = $result->leftJoin('story_ratings', function ($join) {
            $join->on('story_ratings.story_id', '=', 'stories.story_id');
        });

        // subcategory join
        if ($this->data['subcategory']) {
            $result = $result->join('story_categories As story_categories2', function ($join) {
                $join->on('story_categories2.story_id', '=', 'stories.story_id')
                    ->whereNull('story_categories2.category_id');
            });
        }

        // Subject join
        if ($this->data['subject']) {
            $result = $result->join('story_subjects', function ($join) {
                $join->on('story_subjects.story_id', '=', 'stories.story_id');
            });
        }

        // Theme join
        if ($this->data['theme']) {
            $result = $result->join('story_themes', function ($join) {
                $join->on('story_themes.story_id', '=', 'stories.story_id');
            });
        }


        if (isset($data['favstories']) && !empty($data['favstories'])) {
            $result = $result->with("favstories");
        }

        /*$result = $result->where(function ($query) {
           // $query->where('stories.self_story', "=", 1);
        });*/

        $result = $result->where(function ($query) {
            //$query->whereNull('users.deleted_at');

            // Search Title Filter
            if ($this->data['s']) {
                $query->where(function ($query) {
                    $query->where("story_title", "like", "%" . $this->data['s'] . "%");
                    $query->orWhere("short_description", "like", "%" . $this->data['s'] . "%");
                    if (isset($this->data['in_content']) && !empty($this->data['in_content'])) {
                        $query->orwhere("the_story", "like", "%" . $this->data['s'] . "%");
                    }
                });
            }

            // Theme Filter
            if ($this->data['theme']) {
                // $query->where("theme_id", "=", $this->data['theme']);
                $query->where("story_themes.theme_id", "=", $this->data['theme']);
            }

            // Subject Filter
            if ($this->data['subject']) {
                // $query->where("subject_id", "=", $this->data['subject']);
                $query->where("story_subjects.subject_id", "=", $this->data['subject']);
            }

            // Category Filter
            if ($this->data['category']) {
                //$query->where("story_categories.category_id", "=", $this->data['category']);
                $query->where("stories.category_id", "=", $this->data['category']);
            }

            // Sub Category Filter
            if ($this->data['subcategory']) {
                $query->where("story_categories2.sub_category_id", "=", $this->data['subcategory']);
            }

            // User Filter
            if ($this->data['user_id']) {
                $query->where("stories.user_id", "=", $this->data['user_id']);
            }

            // Country Filter
            if (isset($this->data['country']) && !empty($this->data['country'])) {
                $query->where('author_country', 'like', $this->data['country'] . "%");
            }

            // State Filter
            if (isset($this->data['state']) && !empty($this->data['state'])) {
                $query->where('author_address', 'like', "%" . $this->data['state'] . "%");
            }

            // Author Filter
            if (isset($this->data['author']) && !empty($this->data['author'])) {
                $query->where('author_name', 'like', "%" . $this->data['author'] . "%");
            }

            // Favorite Stories Filter
            if (isset($this->data['favoriteStories']) && !empty($this->data['favoriteStories'])) {
                $query->with('favoritestories');
                $query->whereHas(
                    'favoritestories',
                    function ($query) {
                        $query->where('user_id', '=', $this->data['userID']);
                    }
                );
            }
        });

        if ($this->data['sortby'] == "rank_asc") {
            $result = $result->orderBy("story_ratings.average_rate", "asc");
        } elseif ($this->data['sortby'] == "rank_desc") {
            $result = $result->orderBy("story_ratings.average_rate", "desc");
        } elseif ($this->data['sortby'] == "views_asc") {
            $result = $result->orderBy("stories.views", "asc");
        } elseif ($this->data['sortby'] == "views_desc") {
            $result = $result->orderBy("stories.views", "desc");
        } elseif ($this->data['sortby'] == "oldest") {
            $result = $result->orderBy("stories.story_id", "asc");
        } else {
            $result = $result->orderBy("stories.story_id", "desc");
        }

        $result->groupBy('stories.story_title');
        $result->groupBy('stories.author_name');
        $result->groupBy('stories.user_id');
        $result = $result->paginate(isset($this->data['perPage']) ? $this->data['perPage'] : $this->perPage);

        //dd(\DB::getQueryLog());
        return $result;

        dd(\DB::getQueryLog());
    }

    public function comment()
    {
        return $this->hasMany('App\Models\Comment', 'story_id', 'story_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function stories()
    {
        return $this->hasMany('App\Models\SiteUser');
    }

    public function story_star(){
        return $this->hasMany('App\Models\StoryStar','story_id','story_id')->withTrashed();
    }

    static function updateStoryCount($user_id)
    {
        // update user
        $TotalStories = Story::where("user_id", "=", $user_id)->count();
        $user = SiteUser::find($user_id);
        $user->story_count = isset($TotalStories) && !empty($TotalStories) ? $TotalStories : 0;
        $user->save();
    }

    public function getSlugTheme()
    {
        $slug_theme = "";
        if (isset($this->theme)) {
            $slug_theme = str_slug($this->theme->theme_slug);
        }
        return $slug_theme;
    }

    public static function userStoriesDropDown($userId)
    {
        $stories = Story::where(['user_id' => $userId])->get()->toArray();
        $return = [];
        foreach ($stories as $s) {
            $return[$s['story_id']] = $s['story_title'];
        }
        return $return;
    }
}
