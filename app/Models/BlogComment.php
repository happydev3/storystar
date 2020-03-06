<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'user_id', 'parent_comment_id', 'blog_id', 'comment'
    ];
    
     protected $dates = [ "created_at"];
    
    public function user()
    {
        return $this->belongsTo(SiteUser::class, 'user_id');
    }
    
    
    public function blog()
    {
        return $this->belongsTo(Blogs::class, 'blog_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

}
