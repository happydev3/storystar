<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Story;
use App\Models\Theme;
use App\Models\Subject;
use App\Models\SiteUser;
use App\Models\StoryTheme;
use App\Models\StorySubject;
use App\Models\StoryCategory;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class FilteredStoriesController extends Controller
{

    protected $pageData = array();
    public $singularName = 'Story';
    public $pluralName = 'Stories';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;
    public $category_id = "";
    public $sub_category_id = "";
    public $old_id = "";
    public $starType = "";
    protected $advanceFilters = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Story Star";


        // admin auth middleware
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        $this->starType = $request->star_type;

        $this->old_id = $request->old_id;


        /* Set and Get list view for this page */
        if ($this->selectedViewType)
            $this->selectedViewType = $this->listView($request);

        /* List View Data */
        if (request()->ajax()) {


            return $this->getAjaxData($request);
        }

        /* List UI Generator */
        $this->pageData['MainHeading'] = $this->singularName;


        // List Columns
        $viewColumns = [
            ['data' => 'story_id', 'name' => 'story_id', 'orderable' => false, 'title' => 'Story ID', 'searchable' => true, 'class' => 'text-center', 'width' => 50, 'class' => 'no-filter'],
            ['data' => 'story_title', 'name' => 'story_title', 'orderable' => false, 'title' => 'Story', 'searchable' => false, 'data-class' => 'expand', 'class' => 'no-filter', 'width' => 700],
            ['data' => 'average_rate', 'name' => 'average_rate', 'title' => 'Rating', 'data-class' => 'expand', 'width' => 50, 'class' => 'text-center'],
            //['data' => 'short_description', 'name' => 'short_description', 'title' => 'Short Description', 'data-class' => 'expand', 'width' => 200],
            // ['data' => 'author_name', 'name' => 'author_name', 'title' => 'Author', 'data-class' => 'expand', 'width' => 200],
            // ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'data-class' => 'expand', 'width' => 200],
            //['data' => 'average_rate', 'name' => 'average_rate', 'title' => 'Rank', 'data-class' => 'expand', 'width' => 200],
            //['data' => 'views', 'name' => 'views', 'title' => 'Views', 'data-class' => 'expand', 'width' => 100],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '140']
        ];


        $this->pageData['category_id'] = isset($request->category_id) ? $request->category_id : 0;
        $this->pageData['sub_category_id'] = isset($request->sub_category_id) ? $request->sub_category_id : 0;


        $passObj = [];

        if ($request->star_type != "Day") {
            $str = "- ";
            $str .= "Category: " . Category::find($this->pageData['category_id'])->category_title;
            $str .= ", ";
            $str .= "Subcategory: " . SubCategory::find($this->pageData['sub_category_id'])->sub_category_title;

            $passObj['category_id'] = $this->pageData['category_id'];
            $passObj['sub_category_id'] = $this->pageData['sub_category_id'];
            $passObj['starType'] = $this->starType;

        } else {

            $str = "- ";
            $str .= "Category: All";
            $str .= ", ";
            $str .= "Subcategory: All";

        }


        $passObj = \GuzzleHttp\json_encode($passObj);

        $html = $this->getDataTable($builder, "Story_TBL", $viewColumns, 'Avatar', 'admin-filtered-stories-list', '', '', $passObj);

        $this->pageData['refresh_filter'] = isset($request->r) ? $request->r : '';


        return view('admin.list', compact('html'))
            ->with(['callFrom' => 'FilteredStoriesList'])
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)])
            ->with(['categoryStr' => $str])
            ->with(['request' => $request]);
    }


    public function getAjaxData($request)
    {


        $apps = Story::whereNull("stories.deleted_at")->select(
            [
                'stories.*',
                'users.name',
                'users.email',
                'story_ratings.average_rate',
                'story_ratings.total_rate',
                'themes_list.theme_title',
                'subjects_list.subject_title',
                'category_list.category_title',
            ]
        );

        $apps = $apps->leftJoin('users', 'users.user_id', '=', 'stories.user_id');
        $apps = $apps->leftJoin('story_ratings', 'story_ratings.story_id', '=', 'stories.story_id');
        $apps = $apps->join('themes_list', 'themes_list.theme_id', '=', 'stories.theme_id');
        $apps = $apps->join('subjects_list', 'subjects_list.subject_id', '=', 'stories.subject_id');
        $apps = $apps->join('category_list', 'category_list.category_id', '=', 'stories.category_id');

        $apps = $apps->whereNull('users.deleted_at');
        // $apps = $apps->where('stories.views', ">", 100);
        $apps = $apps->where('story_ratings.average_rate', ">=", 4);
        $apps = $apps->where('stories.theme_id', "!=", 41);
        $apps = $apps->where('stories.status', "=", "Active");


        if (isset($request->pass) && !empty($request->pass)) {
            $request->pass = \GuzzleHttp\json_decode($request->pass);

            $this->category_id = isset($request->pass->category_id) ? $request->pass->category_id : 0;
            $this->sub_category_id = isset($request->pass->sub_category_id) ? $request->pass->sub_category_id : 0;
            $this->starType = isset($request->pass->starType) ? $request->pass->starType : 0;

        }

        if ($this->starType != "Day") {

            $apps = $apps->where(function ($query) {


                // Category Filter
                if ($this->category_id) {
                    $query->where("stories.category_id", "=", $this->category_id);
                }

                // Sub Category Filter
                if ($this->sub_category_id) {
                    $query->where("stories.sub_category_id", "=", $this->sub_category_id);

                }


            });
        }


        $apps = $apps->orderBy('stories.created_timestamp', "desc");
        $apps = $apps->orderBy('story_ratings.average_rate', "desc");

        $apps = $apps->groupBy('stories.story_title');
        $apps = $apps->groupBy('stories.author_name');


        $table = DataTables::of($apps);


        // Action Coloumn
        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-stories-delete', $apps->story_id);

            $storyStar = "";
            //$apps->average_rate >= 4 && $apps->views >= 100
            if ($apps->theme_id != 41 && $apps->average_rate >= 4) {
                $storyStar = '<a href="' . route('admin-story-star-addfromstories', ['story_id' => $apps->story_id, 'type' => 'day']) . '" class="btn btn-xs bg-color-orange txt-color-white" rel="tooltip" data-placement="top" data-original-title=""><i class="glyphicon glyphicon-star"></i> Add Story Of Day </a>';
                $storyStar .= ' <a href="' . route('admin-story-star-addfromstories', ['story_id' => $apps->story_id, 'type' => 'week', "old_id" => $this->old_id]) . '" class="btn btn-xs  bg-color-green txt-color-white" rel="tooltip" data-placement="top" data-original-title=""><i class="glyphicon glyphicon-star"></i> Add Story of Week</a>';
            }
            return '<a href="' . route('admin-stories-edit', ['callFrom' => 'filtered', 'id' => $apps->story_id]) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title=""><i class="glyphicon glyphicon-edit"></i> Edit</a>
                    <a href="' . route('admin-stories-detail', $apps->story_id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title=""><i class="glyphicon glyphicon-th-list"></i> Detail</a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title=""><i class="glyphicon glyphicon-remove" ></i> Delete</a>
                    <a target="_blank" href="' . route('app-story', $apps->story_id) . '" class="btn btn-xs bg-color-blueDark txt-color-white" rel="tooltip" data-placement="top" data-original-title=""><i class="fa fa-external-link "></i> View Story at Front-end</a>
                    ' . $storyStar;
        });

        $table->editColumn('created_timestamp', function ($apps) {
            return my_date($apps->created_timestamp);
        });

        $table->editColumn('story_title', function ($apps) {

            $rank = "";
            $categoriesText = "";
            $title = ' <a href="' . route('admin-stories-detail', $apps->story_id) . '">' . $apps->story_title . '</a>';

            $floorRank = round(($apps->average_rate * 2)) / 2;
            $rankNo = ceil(number_format($apps->average_rate, 1));


            // Categories
            /* $categories = []; $categories = StoryCategory::where("story_id", "=", "$apps->story_id")->whereNull('sub_category_id')
                 ->join("category_list", "category_list.category_id", "=", "story_categories.category_id")
                 ->get()->toArray()

            if ($categories)
                $categories = array_column($categories, 'category_title');*/;

            // Sub Categories
            $subCategories = [];
            $subCategories = StoryCategory::where("story_id", "=", "$apps->story_id")->whereNull('category_id')
                ->join("sub_category_list", "sub_category_list.sub_category_id", "=", "story_categories.sub_category_id")
                ->get()->toArray();


            $subjects = [];
            $subjects = StorySubject::select(\DB::raw('group_concat(" ",subjects_list.subject_title) as subjects'))
                ->where("story_id", "=", "$apps->story_id")
                ->join("subjects_list", "subjects_list.subject_id", "=", "story_subjects.subject_id")
                ->get()->toArray();
            if ($subjects)
                $subjects = isset($subjects[0]['subjects']) ? $subjects[0]['subjects'] : '';

            $themes = [];
            $themes = StoryTheme::select(\DB::raw('group_concat(" ",themes_list.theme_title) as themes'))
                ->where("story_id", "=", "$apps->story_id")
                ->join("themes_list", "themes_list.theme_id", "=", "story_themes.theme_id")
                ->get()->toArray();
            if ($themes)
                $themes = isset($themes[0]['themes']) ? $themes[0]['themes'] : '';

            if ($subCategories)
                $subCategories = array_column($subCategories, 'sub_category_title');


            for ($i = 1; $i <= $floorRank; $i++) {
                $rank .= '<i class="fa fa-star fa-2x text-primary" style="color: #47588F"></i>';
            }

            foreach ($subCategories as $subCat) {
                // $categoriesText .= "<br/>This story is listed as: $apps->category_title For $subCat / Theme: $apps->theme_title / Subject: $apps->subject_title";
                $categoriesText .= "<br/>This story is listed as: $apps->category_title For $subCat / <span style='color: #47588F'>Theme:</span> $themes / <span style='color: #47588F'>Subject:</span> $subjects";

            }


            $apps->total_rate = isset($apps->total_rate) ? $apps->total_rate : 0;

            $str = "<b>" . $title . "</b> by  <span style='color: #47588F'>" . ucfirst($apps->author_name) . " </span><br/>";
            $str .= '<div class="product-deatil" style="padding: 5px 0 5px 0;">' . $rank . '
                     <span class="fa fa-2x"><h5>(' . number_format($apps->average_rate, 1) . ') Rank</h5></span>
                     </div>';
            $str .= "Post date: " . my_date($apps->created_timestamp, "Y-m-d") . " / Views: $apps->views / Votes: $apps->total_rate  / Country: $apps->author_country";
            $str .= "<br/>" . $categoriesText . "<br/><br/>";
            $str .= decodeStr($apps->short_description);

            return decodeStr($str);


        });


        $table->editColumn('short_description', function ($apps) {
            return decodeStr($apps->short_description);
        });

        $table->filterColumn('created_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(created_timestamp),' % d -%m -%Y % h:%i:%s') like ?", ["%$keyword%"]);
        });
        $table->editColumn('updated_timestamp', function ($apps) {
            return my_date($apps->updated_timestamp);
        });

        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(updated_timestamp),' % d -%m -%Y % h:%i:%s') like ?", ["%$keyword%"]);
        });


        $table->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("author_name.author_name like ?", ["%$keyword%"]);
        });

        $table->filterColumn('email', function ($query, $keyword) {
            $query->whereRaw("users.email like ?", ["%$keyword%"]);
        });

        $table->filterColumn('views', function ($query, $keyword) {
            $query->whereRaw("stories.views = $keyword");
        });

        $table->filterColumn('average_rate', function ($query, $keyword) {
            $query->whereRaw("story_ratings.average_rate = $keyword");
        });

        $table->editColumn('average_rate', function ($apps) {
            return number_format($apps->average_rate, 1);
        });

        $table->rawColumns(['story_title', 'action']);

        return $table->make(true);
    }


}
