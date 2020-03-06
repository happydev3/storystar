<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoryStarRequest;
use App\Models\PointsHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\StoryStar;
use App\Models\SubCategory;
use App\Models\Story;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class StoryStarController extends Controller
{
    protected $pageData = array();
    public $singularName = 'StoryStar';
    public $pluralName = 'Story Stars';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;
    protected $story_id = 0;
    protected $latestIds = [];

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
        /* Set and Get list view for this page*/
        if ($this->selectedViewType) {
            $this->selectedViewType = $this->listView($request);
        }

        /* List View Data */
        if (request()->ajax()) {
            return $this->getAjaxData($request);
        }

        /* List UI Generator */
        $this->pageData['MainHeading'] = $this->singularName;

        // List Columns
        $viewColumns = [
            /*[
                'data' => 'storystar_id',
                'name' => 'storystar_id',
                'title' => 'StoryStar ID',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 50
            ],*/
            [
                'data' => 'story_title',
                'name' => 'story_title',
                'title' => 'Story Title',
                'searchable' => true,
                'class' => 'text-left',
                'width' => 150
            ],
            [
                'data' => 'author_name',
                'name' => 'author_name',
                'title' => 'Author',
                'searchable' => true,
                'class' => 'text-left',
                'width' => 150
            ],
            [
                'data' => 'display_type',
                'name' => 'display_type',
                'title' => 'Type',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 50
            ],
            [
                'data' => 'category_title',
                'name' => 'category_title',
                'title' => 'Category',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 50
            ],
            [
                'data' => 'sub_category_title',
                'name' => 'sub_category_title',
                'title' => 'Subcategory',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 50
            ],
            [
                'data' => 'date_from',
                'name' => 'date_from',
                'title' => 'Featured Date',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 50
            ],
            /*[
                'data' => 'date_from',
                'name' => 'date_from',
                'title' => 'Date From',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 50
            ],
            [
                'data' => 'date_to',
                'name' => 'date_to',
                'title' => 'Date To',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 50
            ],
            [
                'defaultContent' => '',
                'data' => 'action',
                'name' => 'action',
                'title' => 'Action',
                'render' => '',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
                'footer' => '',
                'class' => 'text-center',
                'width' => '120px'
            ]*/
        ];

        $html = $this->getDataTable($builder, "StoryStar_TBL", $viewColumns, 'Avatar', 'admin-story-star-list');

        /**
         * Current Story Star List
         */
        $list = "";
        $list = StoryStar::select([
            "story_star.*",
            "stories.story_title",
            "stories.author_name",
            "category_list.category_title",
            "sub_category_list.sub_category_title"
        ])
        ->join('stories', 'stories.story_id', '=', 'story_star.story_id')
        ->join('category_list', 'category_list.category_id', '=', 'stories.category_id')
        ->join('sub_category_list', 'sub_category_list.sub_category_id', '=', 'stories.sub_category_id')
        ->where("story_star.is_active", "=", 1)
        ->orderBy("story_star.type", "asc")
        ->orderBy("category_list.category_title", "asc")
        ->orderBy("sub_category_list.sub_category_title", "asc")
        ->get();

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)])
            ->with(['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (isset($request->story_id)) {
            $this->story_id = $request->story_id;
        }

        $this->pageData['MainHeading'] = "Add " . $this->singularName;
        $this->pageData['PageTitle'] = "Add " . $this->singularName;
        $this->pageData['SubNav'] = "Add " . $this->singularName;
        $this->pageData['NavHeading'] = "New " . $this->singularName;

        // Add  App Form
        $form = $this->form();

        return view('admin.add')
            ->with(['pageData' => $this->pageData])
            ->with(compact('form'))
            ->with(compact('jsValidator'));
    }

    public function form($id = "")
    {
        $data = array();
        if ($id):
            $action = route('admin-story-star-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-story-star-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm(
            'StoryStarFrm',
            $action,
            $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'],
            true
        );

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);
        $updatedAppFiled = [];
        $storyOptions = [];

        // Get edit from data in case of edit record
        if ($id) {
            $data = StoryStar::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');
            $storyOptions = "";
            $storyOptions = Story::whereNull("stories.deleted_at")->select(
                ['stories.story_id as id', 'story_title as text', 'average_rate', 'stories.theme_id']
            )
            ->join('story_ratings', 'story_ratings.story_id', '=', 'stories.story_id', "LEFT");

            if ($data->category_id) {
                $storyOptions->where('stories.category_id', $data->category_id);
            }
            if ($data->sub_category_id) {
                $storyOptions->where('sub_category_id', $data->sub_category_id);
            }

            $storyOptions->where('views', ">", 100);
            $storyOptions->where('average_rate', ">=", 4);
            $storyOptions->where("theme_id", "!=", "41");
            $storyOptions->where("stories.subject_id", "!=", "164");
            $storyOptions = $storyOptions->get()->toArray();
            $storyOptions = array_combine(array_column($storyOptions, 'id'), array_column($storyOptions, 'text'));
        }

        $storyOrderOptions = [];
        $total = StoryStar::all()->count();
        for ($i = 0; $i < $total; $i++) {
            $storyOrderOptions[$i] = $i;
        }

        $fmForm
            ->add(array(
                "col" => 4,
                "type" => "ajax_select",
                "options" => getCategories(),
                "name" => "category_id",
                "label" => "Choose Category",
                "value" => (isset($data->category_id) ? $data->category_id : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2'],
                "ajax_bind" => [
                    [
                        'dependent' => 'story_id',
                        'url' => route("admin-stories-form-options") . "?get=stories"

                    ]
                ]
            ))
            ->add(array(
                "col" => 4,
                "type" => "ajax_select",
                "options" => getSubCategories(),
                "name" => "sub_category_id",
                "label" => "Choose Sub Category",
                "value" => (isset($data->sub_category_id) ? $data->sub_category_id : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2'],
                "ajax_bind" => [
                    [
                        'dependent' => 'story_id',
                        'url' => route("admin-stories-form-options") . "?get=stories"

                    ]
                ]
            ))
            ->add(array(
                "col" => 4,
                "type" => "select",
                "options" => getStoryStarType(),
                "name" => "type",
                "label" => "Choose Type",
                "value" => (isset($data->type) ? $data->type : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 6,
                "icon" => "icon-append fa fa-calendar",
                "type" => "text-date",
                "name" => "date_from",
                "label" => "Date From",
                "value" => (isset($data->date_from) ? $data->date_from : ""),
            ))
            ->add(array(
                "col" => 6,
                "icon" => "icon-append fa fa-calendar",
                "type" => "text-date",
                "name" => "date_to",
                "label" => "Date To",
                "value" => (isset($data->date_to) ? $data->date_to : ""),
            ))
            ->add(array(
                "col" => 12,
                "type" => "select",
                "options" => $storyOptions,
                "name" => "story_id",
                "label" => "Choose Story",
                "value" => (isset($data->story_id) ? $data->story_id : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ));

        return $fmForm->getForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoryStarRequest $request)
    {
        try {
            $oldStoryStars = StoryStar::where('type',$request['type']);
            if($request['type'] == 'week'){
                $oldStoryStars = $oldStoryStars->where('sub_category_id',$request['sub_category_id']);
            }
            $oldStoryStars->update(['is_active'=>'0']);
            $oldStoryStars->delete();
            $display_type = 'Week';
            if($request['type'] == 'day'){
                $display_type = "Day";
            }
            $data = StoryStar::create([
                'category_id' => $request['category_id'],
                'sub_category_id' => $request['sub_category_id'],
                'story_id' => $request['story_id'],
                'date_to' => $request['date_to'],
                'date_from' => $request['date_from'],
                'type' => $request['type'],
                'display_type' => $display_type,
                'created_timestamp' => time(),
                'updated_timestamp' => time(),
                'is_active' => '1'
            ]);

            if ($data->storystar_id) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->pageData['PageTitle'] = $this->singularName . " Detail";
        $this->pageData['SubNav'] = "Add " . $this->singularName;
        $this->pageData['MainHeading'] = $this->singularName . " Detail";

        $detailData = array();
        $detailData = StoryStar::Select(
            'story_id as ID',
            'story_title as StoryStar Title',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['Title'] = decodeStr($detailData['story_title']);
        $detailData['Created Date Time'] = my_date($detailData['Created Date Time'], '', '');
        $detailData['Updated Date Time'] = my_date($detailData['Updated Date Time'], '', '');

        return view('admin.detail')->with(['pageData' => $this->pageData])->with(compact('detailData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->pageData['MainHeading'] = "Edit " . $this->singularName;
        $this->pageData['PageTitle'] = "Edit " . $this->singularName;
        $this->pageData['SubNav'] = "Add Story Star";
        $this->pageData['NavHeading'] = "Edit " . $this->singularName;

        $form = $this->form($id);

        return view('admin.add')
            ->with(['pageData' => $this->pageData])
            ->with(compact('form'))
            ->with(compact('jsValidator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoryStarRequest $request, $id)
    {
        // Update Backend User
        try {
            $updateRecord = StoryStar::find($id);
            $updateRecord->category_id = $request->category_id;
            $updateRecord->sub_category_id = $request->sub_category_id;
            $updateRecord->story_id = $request->story_id;
            $updateRecord->date_to = $request->date_to;
            $updateRecord->date_from = $request->date_from;
            $updateRecord->type = $request->type;
            $updateRecord->updated_timestamp = time();

            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->route("admin-story-star-list");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Soft Delete Method
        try {
            $user = StoryStar::find($id);
            if ($user->delete()) {
                $user->comment()->delete();
                $request->session()->flash('alert-success', $this->singularName . ' has been deleted successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->back();
    }

    public function getAjaxData($request)
    {
        // List Type Check On Get Data From DB
        if ($this->selectedViewType == 'simple') {
            // Remove action column for query
            if (in_array('action', $this->listViewSimple)) {
                $this->listViewSimple = array_diff($this->listViewSimple, array('action'));
            }
            $columns = $this->listViewSimple;

        } else // All and Custom Case
        {
            $columns = ['*'];
        }

        /*$f = $f2 = $f3 = [];
        $f = StoryStar::select('storystar_id')->where("type", "Week")->where("category_id", "1")->orderBy("storystar_id", "desc")->take(3)->get()->toArray();
        $f = array_column($f, 'storystar_id');
        $f2 = StoryStar::select('storystar_id')->where("type", "Week")->where("category_id", "2")->orderBy("storystar_id", "desc")->take(3)->get()->toArray();
        $f2 = array_column($f2, 'storystar_id');
        $f3 = StoryStar::select('storystar_id')->where("type", "Day")->orderBy("storystar_id", "desc")->take(1)->get()->toArray();
        $f3 = array_column($f3, 'storystar_id');
        $this->latestIds = array_merge($f, $f2, $f3);*/

        $apps = StoryStar::select([
            "story_star.*",
            "stories.story_title",
            "stories.author_name",
            "category_list.category_title",
            "sub_category_list.sub_category_title"
        ])->withTrashed()
            ->join('stories', 'stories.story_id', '=', 'story_star.story_id')
            ->join('category_list', 'category_list.category_id', '=', 'stories.category_id')
            ->join('sub_category_list', 'sub_category_list.sub_category_id', '=', 'stories.sub_category_id')
            ->orderBy("story_star.created_timestamp", "desc");

        $table = DataTables::of($apps);

        $table->editColumn('created_timestamp', function ($apps) {
            return my_date($apps->created_timestamp);
        });
        $table->filterColumn('author_name', function ($query, $keyword) {
            $query->whereRaw("stories.author_name like ?", ["%$keyword%"]);
        });
        $table->filterColumn('created_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(created_timestamp),' % d -%m -%Y % h:%i:%s') like ?",
                ["%$keyword%"]);
        });
        $table->editColumn('updated_timestamp', function ($apps) {
            return my_date($apps->updated_timestamp);
        });
        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(updated_timestamp),' % d -%m -%Y % h:%i:%s') like ?",
                ["%$keyword%"]);
        });
        $table->editColumn('story_title', function ($apps) {
            return decodeStr($apps->story_title);
        });
        $table->filterColumn('story_title', function ($query, $keyword) {
            $query->whereRaw("story_title like ?", ["%$keyword%"]);
        });
        $table->filterColumn('category_title', function ($query, $keyword) {
            $query->whereRaw("category_list.category_title like ?", ["%$keyword%"]);
        });
        $table->filterColumn('sub_category_title', function ($query, $keyword) {
            $query->whereRaw("sub_category_list.sub_category_title like ?", ["%$keyword%"]);
        });
        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters) {
            setAdvanceFilter($request, $table);
        }

        return $table->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addStoryStarFromStoriesList(Request $request)
    {
        if (isset($request->story_id) && isset($request->type)) {
            PointsHistory::selectStar($request);
            $story_information = Story::find($request->story_id);
            $oldStoryStars = StoryStar::where('type',$request->type);
            if($request->type == 'week'){
                $oldStoryStars = $oldStoryStars->where('sub_category_id',$story_information->sub_category_id);
            }
            $oldStoryStars->update(['is_active'=>'0']);
            $oldStoryStars->delete();

            $date1 = \Carbon\Carbon::today()->toDateString();
            if ($request->type == 'day') {
                $display_type = 'Day';
                $date2 = \Carbon\Carbon::today()->toDateString();
            } else {
                $display_type = 'Week';
                $date2 = \Carbon\Carbon::today()->addDay(7)->toDateString();
            }

            $data = StoryStar::create([
                'category_id' => $story_information->category_id,
                'sub_category_id' => $story_information->sub_category_id,
                'story_id' => $story_information->story_id,
                'date_to' => $date2,
                'date_from' => $date1,
                'type' => $request->type,
                'display_type' => $display_type,
                'created_timestamp' => time(),
                'updated_timestamp' => time(),
                'is_active' => 1
            ]);

            if ($data->storystar_id) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue. Please try again!');
            }
        }
        return redirect()->back();
    }
    public function getHighRatedStories($category_id = 1, $sub_category_id = 1, $old_id, $star_type, $r){
        $stories = Story::join('story_ratings', 'story_ratings.story_id', '=', 'stories.story_id')
        ->where('story_ratings.average_rate','>=','4');
        if($star_type == 'Fic' || $star_type == 'Non'){
            $category = ($star_type == 'Fic') ? "Fiction" : "True Stories";
            $title = 'List of Stories for '.$category.' Story of the Week'; 
            $stories = $stories->where('category_id',$category_id);
        }
        elseif($star_type == 'Week'){
            $sub_category = SubCategory::where('sub_category_id',$sub_category_id)->first();
            $title = 'List of Stories for '.$sub_category->sub_category_title.' Story of the Week'; 
            $stories = $stories->where('sub_category_id',$sub_category_id);
        }
        else{
            $title = 'List of Stories for Story Star of the Day'; 
        }
        $stories = $stories->groupBy('stories.story_id')
        ->select([
            'stories.*',
            'story_ratings.average_rate'
        ])->orderBy('story_ratings.average_rate','desc')->orderBy('stories.story_id','desc')->paginate(50);
        return view('admin.change-story-star',compact('stories','title','star_type'))
            ->with(['pageData' => $this->pageData]);
    }
}
