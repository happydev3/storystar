<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'comments';
    protected $primaryKey = 'comment_id';

    protected $dates = ['deleted_at', "created_at"];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id', 'user_id', 'parent_comment_id', 'story_id', 'comment',  'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\SiteUser', 'user_id');
    }
    
    
    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id')->with('category');
    }

    public function parent()
    {
        return $this->belongsToOne(static::class, 'parent_comment_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_comment_id')->orderBy("comment_id", "desc");
    }
    public function getCommentedAtAttribute(){
        return $this->created_at->format('m/d/Y H:i');
    }
}
