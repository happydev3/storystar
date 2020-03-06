<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    const WRITE_TIP_OF_THE_DAY = 1;
    const WRITING_INSPPIRATION = 2;
    const INTERESTING_ARTICLES_FOR_WRITERS = 3;
    const NEWS_AND_INFORMATION = 4;

   const BLOG_SECTIONS = [
       self::WRITE_TIP_OF_THE_DAY => 'Writing Tips',
       self::WRITING_INSPPIRATION => 'Writing Inspiration',
       self::INTERESTING_ARTICLES_FOR_WRITERS => 'Useful Articles',
       self::NEWS_AND_INFORMATION => 'News & Info'
   ];   
    
    protected $fillable = [
        'user_id','title','content','section_id','is_pin'
    ];
    
    public function blogcomment()
    {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id')
                ->with('user')
                ->orderBy('created_at','desc');

    }
}
