<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Comment;
use App\Models\Story;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class CommentsController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Comment';
    public $pluralName = 'Comments';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;
    public $storyID = '';

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Comments";

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


        $this->storyID = $request->story_id;


        /* Set and Get list view for this page*/
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
            ['data' => 'comment_id', 'name' => 'comment_id', 'title' => 'ID', 'searchable' => true, 'class' => 'text-center', 'width' => 50],
            ['data' => 'name', 'name' => 'name', 'title' => 'Commented By', 'data-class' => 'expand', 'width' => 150],
            ['data' => 'comment', 'name' => 'comment', 'title' => 'Comment', 'data-class' => 'expand'],
            ['data' => 'commented_at', 'name' => 'commented_at', 'title' => 'Commented At', 'data-class' => 'expand', 'width' => 150],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "Comment_TBL", $viewColumns, 'Avatar', false, [[0, "desc"]]);

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

    public function form($id = "", $story_id = "")
    {


        $data = array();
        if ($id):
            $action = route('admin-comments-update', [$id, $story_id]);
            $method = 'patch';
        else:
            $action = route('admin-comments-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('CommentFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {

            $data = Comment::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');

            $updatedAppFiled =
                [
                    //"attr" => ['readonly' => 'readonly'],
                    //"tooltip" => "You can't change the Field."
                ];
        }


        $fmForm
            ->add(array(
                    "col" => 12,
                    "type" => "textarea",
                    "name" => "comment",
                    "label" => "Comment Text",
                    "value" => (isset($data->comment) ? $data->comment : ""),
                    "attr" => ["rows" => 30],
                )
            );


        return $fmForm->getForm();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {


        try {
            $data = Comment::create([
                'comments_title' => $request['comments_title'],
                'created_timestamp' => time(),
                'updated_timestamp' => time()
            ]);

            if ($data->comment_id) {
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

        $detailData = Comment::Select(
            'comment_id as ID',
            'comments_title as Comment Title',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['Created Date Time'] = my_date($detailData['Created Date Time'], '', '');
        $detailData['Updated Date Time'] = my_date($detailData['Updated Date Time'], '', '');


        return view('admin.detail')
            ->with(['pageData' => $this->pageData])
            ->with(compact('detailData'));;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $story_id)
    {

        $this->pageData['MainHeading'] = "Edit " . $this->singularName;
        $this->pageData['PageTitle'] = "Edit " . $this->singularName;
        $this->pageData['SubNav'] = "AddApp";
        $this->pageData['NavHeading'] = "Edit " . $this->singularName;

        $form = $this->form($id, $story_id);

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
    public function update(CommentRequest $request, $id, $story_id)
    {

        // Update Backend User
        try {
            $updateRecord = Comment::find($id);

            $updateRecord->comment = $request->comment;
            //  $updateRecord->updated_timestamp = time();


            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect(route("admin-stories-edit", [$story_id]) . "#comments");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $story = "";
        // Soft Delete Method
        try {

            $comment = Comment::find($id);

            if ($comment->delete()) {

                Comment::where("parent_comment_id", "=", $id)->delete();

                if ($request->story_id) {
                    $story = Story::find($request->story_id);

                    // Update Comment Count In Cache Field of Story Table.
                    $count = Comment::where('story_id', "=", "$story->story_id")->count();
                    $story->comment_count = $count;
                    $story->save();
                }


                $request->session()->flash('alert-success', $this->singularName . ' has been deleted successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }


        return redirect(route("admin-stories-edit", [$story->story_id]) . "#comments");

    }


    public function getAjaxData($request)
    {


        // List Type Check On Get Data From DB
        if ($this->selectedViewType == 'simple') {
            // Remove action column for query
            if (in_array('action', $this->listViewSimple))
                $this->listViewSimple = array_diff($this->listViewSimple, array('action'));
            $columns = $this->listViewSimple;

        } else
            // All and Custom Case
            $columns = ['*'];


        $apps = Comment::select(['comments.*', 'users.name'])
                            ->leftJoin("users", "users.user_id", "comments.user_id")
                            ->where('comments.story_id', "=", $request->story_id);
        $table = DataTables::of($apps);
        $table->addColumn('commented_at', function($apps){
            return $apps->commented_at; 
        });
        $table->addColumn('action', function ($apps) {
            $deleteURL = route('admin-comments-delete', [$apps->comment_id, $apps->story_id]);
            return '<a href="' . route('admin-comments-edit', [$apps->comment_id, $this->storyID]) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i> </a>
                    ';
        });

//        $table->editColumn('created_timestamp', function ($apps) {
//            return my_date($apps->created_timestamp);
//        });
//        $table->filterColumn('created_timestamp', function ($query, $keyword) {
//            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(created_timestamp),' % d -%m -%Y % h:%i:%s') like ?", ["%$keyword%"]);
//        });
//        $table->editColumn('updated_timestamp', function ($apps) {
//            return my_date($apps->updated_timestamp);
//        });
//        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
//            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(updated_timestamp),' % d -%m -%Y % h:%i:%s') like ?", ["%$keyword%"]);
//        });

        $table->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("users.name like ?", ["%$keyword%"]);
        });


        $table->rawColumns(['action']);

        $table->editColumn('name', function ($app) {
            return $app->name?$app->name:'Anonymous';
        });
        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }
}
