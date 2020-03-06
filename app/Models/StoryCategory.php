<?php

namespace App\Models;

use App\Models\StoryTheme;
use App\Models\StorySubject;

use Illuminate\Database\Eloquent\Model;


class StoryCategory extends Model
{


    protected $table = 'story_categories';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'sub_category_id', 'story_id', 'created_timestamp'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];


    public function subcategories()
    {
        return $this->hasMany(StoryCategory::class, 'sub_category_id', 'sub_category_id');
    }

    public function categories()
    {
        return $this->hasMany(StoryCategory::class, 'category_id', 'category_id');
    }


    public function subcategory(){
        return $this->belongsTo('App\Models\SubCategory','sub_category_id','sub_category_id');
    }


    public function updateMultipleCategories($request, $id, $callFrom = '')
    {


        $records = $recordsTheme = [];

        // Sub Category ID
        $records[] = [
            'story_id' => $id,
            'created_timestamp' => time(),
            'sub_category_id' => $request['sub_category_id'],
            'update_by' => 'client'
        ];


        // For Multiple Sub Categories
        $results = $request->multiple_sub_category_id;

        if ($results) {
            foreach ($results as $res):
                if ($res != $request['sub_category_id']) {
                    $records[] = [
                        'story_id' => $id,
                        'created_timestamp' => time(),
                        'sub_category_id' => $res,
                        'update_by' => 'admin'
                    ];
                }
            endforeach;
        }


        if (isset($callFrom) && $callFrom == 'ClientSide') {

            // Delete if Already Added From Client Side
            $s = StoryCategory::where("story_id", "=", "$id")->where("update_by", "=", "client");
            $s->delete();

        } else {
            // Delete if Already Added From both Client and admin side
            $s = StoryCategory::where("story_id", "=", "$id");
            $s->delete();
        }

        // Insert in  StoryCategory;
        StoryCategory::insert($records);


        /***********  Mulitiple Theme ID *********/
        $recordsTheme[] = [
            'story_id' => $id,
            'theme_id' => $request['theme_id'],
            'created_timestamp' => time(),
            'update_by' => 'client'
        ];
        // For Multiple Sub Categories
        $results = $request->multiple_theme_id;

        $records = [];
        if ($results) {
            foreach ($results as $res):
                if ($res != $request['theme_id']) {
                    $recordsTheme[] = [
                        'story_id' => $id,
                        'created_timestamp' => time(),
                        'theme_id' => $res,
                        'update_by' => 'admin'
                    ];
                }
            endforeach;
        }

        if (isset($callFrom) && $callFrom == 'ClientSide') {

            // Delete if Already Added From Client Side
            $s = StoryTheme::where("story_id", "=", "$id")->where("update_by", "=", "client");
            $s->delete();

        } else {
            // Delete if Already Added From both Client and admin side
            $s = StoryTheme::where("story_id", "=", "$id");
            $s->delete();
        }

        // Insert in  StoryCategory;
        StoryTheme::insert($recordsTheme);


        /***********  Mulitiple Subject ID *********/
        $recordsSubject[] = [
            'story_id' => $id,
            'subject_id' => $request['subject_id'],
            'created_timestamp' => time(),
            'update_by' => 'client'
        ];
        // For Multiple Sub Categories
        $results = $request->multiple_subject_id;

        $records = [];
        if ($results) {
            foreach ($results as $res):
                if ($res != $request['subject_id']) {
                    $recordsSubject[] = [
                        'story_id' => $id,
                        'created_timestamp' => time(),
                        'subject_id' => $res,
                        'update_by' => 'admin'
                    ];
                }
            endforeach;
        }


        if (isset($callFrom) && $callFrom == 'ClientSide') {

            // Delete if Already Added From Client Side
            $s = StorySubject::where("story_id", "=", "$id")->where("update_by", "=", "client");
            $s->delete();

        } else {
            // Delete if Already Added From both Client and admin side
            $s = StorySubject::where("story_id", "=", "$id");
            $s->delete();
        }

        // Insert in  StoryCategory;


        StorySubject::insert($recordsSubject);

        return 1;

    }

}
