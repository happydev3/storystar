<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FlagRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Flag;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class FlagController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Flagged Story';
    public $pluralName = 'Flagged Story';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;


    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Flagged Stories List";

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
            ['data' => 'story_id', 'name' => 'story_id', 'title' => 'Story ID', 'searchable' => true, 'class' => 'text-center', "width" => 100],
            // ['data' => 'user_id', 'name' => 'user_id', 'title' => 'Flagged By', 'searchable' => true, 'class' => 'text-left'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Flagged By', 'searchable' => true, 'class' => 'text-center'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email Who Flagged', 'searchable' => true, 'class' => 'text-center'],
            ['data' => 'story_title', 'name' => 'story_title', 'title' => 'Story Title', 'searchable' => true, 'class' => 'text-left'],
            ['data' => 'message', 'name' => 'message', 'title' => 'Message', 'searchable' => true, 'class' => 'text-left'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Story Status', 'searchable' => true, 'class' => 'text-left'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Flagged At', 'data-class' => 'expand', 'width' => 200],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "User_TBL", $viewColumns, 'Avatar', 'admin-flag-list');


        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);

    }


    public function form($id = "")
    {


        $data = array();
        if ($id):
            $action = route('admin-flag-update', $id);

            $method = 'patch';
        else:
            $action = route('admin-flag-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('FlagFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {
            $data = Flag::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');

            $updatedAppFiled =
                [
                    //"attr" => ['readonly' => 'readonly'],
                    //"tooltip" => "You can't change the Field."
                ];
        }


        $fmForm
            ->add(
                array(
                    "col" => 12,
                    "type" => "text",
                    "name" => "page_name",
                    "label" => "Page Name",
                    "value" => (isset($data->page_name) ? $data->page_name : ""),
                ), [
                    "attr" => ['readonly' => 'readonly'],
                    "tooltip" => "You can't change the Field."
                ]
            )
            ->add(array(
                "col" => 12,
                "type" => "textarea",
                "name" => "Flag_code",
                "label" => "Flag_code",
                "value" => (isset($data->Flag_code) ? $data->Flag_code : ""),

            ));


        return $fmForm->getForm();

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
        $this->pageData['SubNav'] = "Add WebUser";
        $this->pageData['MainHeading'] = $this->singularName . " Detail";


        $detailData = array();

        $detailData = Flag::Select(
            'id as User ID',
            'page_name as Page Name',
            'Flag_code as Flag Code',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'


        )->Find($id)->toArray();

        $detailData['Flag'] = $detailData['Flag Code'];
        $detailData['Flag Code'] = "<code>" . htmlentities($detailData['Flag Code']) . "</code>";
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
    public function edit($id)
    {

        $this->pageData['MainHeading'] = "Edit " . $this->singularName;
        $this->pageData['PageTitle'] = "Edit " . $this->singularName;
        $this->pageData['SubNav'] = "Edit " . $this->singularName;
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
    public function update(FlagRequest $request, $id)
    {

        // Update Backend User
        try {
            $updateRecord = Flag::find($id);
            $updateRecord->Flag_code = $request->Flag_code;
            $updateRecord->updated_timestamp = time();

            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->route("admin-flag-list");

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


        $apps = Flag::select($columns);


        $apps = Flag::whereNull("stories.deleted_at")->select(
            [
                'flag_story.*',
                'users.name',
                'users.email',
                'stories.status',
                'stories.story_title',
            ]
        )
            ->join('users', 'users.user_id', '=', 'flag_story.user_id')
            ->join('stories', 'stories.story_id', '=', 'flag_story.story_id')
            ->where("stories.status","=","Inactive")
            ->orderBy("flag_story.flag_id", "desc")
        ;


        $table = DataTables::of($apps);


        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-stories-delete', $apps->story_id);

            return '<a href="' . route('admin-stories-edit', ['callFrom' => 'flag', 'id' => $apps->story_id]) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="' . route('admin-stories-detail', $apps->story_id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail Story"><i class="glyphicon glyphicon-th-list"></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete Story"><i class="glyphicon glyphicon-remove" ></i> </a>
                    ';
        });


        $table->editColumn('updated_timestamp', function ($apps) {
            return my_date($apps->updated_timestamp);
        });
        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(updated_timestamp), '%d-%m-%Y %h:%i:%s') like ? ", [" % $keyword % "]);
        });


        $table->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("users.name like ?", ["%$keyword%"]);
        });

        $table->filterColumn('email', function ($query, $keyword) {
            $query->whereRaw("users.email like ?", ["%$keyword%"]);
        });

        $table->filterColumn('story_title', function ($query, $keyword) {
            $query->whereRaw("stories.story_title like ?", ["%$keyword%"]);
        });

        $table->filterColumn('status', function ($query, $keyword) {
            $query->whereRaw("stories.status like ?", ["$keyword%"]);
        });





        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }
}
