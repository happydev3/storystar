<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PointsBadWordsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\PointsBadWords;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class PointsBadWordsController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Points - Bad Words';
    public $pluralName = 'Points - Bad Word';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_at', 'updated_at', 'action'];
    protected $selectedViewType = false;
    protected $validationRules = ['title' => 'required', 'is_active' => 'required'];

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Bad Words";

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
            [
                'data' => 'id',
                'name' => 'id',
                'title' => 'ID',
                'searchable' => false,
                'class' => 'text-center',
                "width" => 100
            ],
            [
                'data' => 'title',
                'name' => 'title',
                'title' => 'Title',
                'searchable' => true,
                'class' => 'text-center'
            ],
            [
                'data' => 'updated_at',
                'name' => 'updated_at',
                'title' => 'Updated On',
                'data-class' => 'expand',
                'width' => 200
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
            ]
        ];

        $html = $this->getDataTable(
            $builder,
            "PointsBadWords_TBL",
            $viewColumns,
            'Avatar',
            'admin-points-bad-words-list'
        );

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);
    }

    public function form($id = "")
    {
        $data = array();
        if ($id) {
            $action = route('admin-points-bad-words-update', $id);
            $method = 'patch';
        } else {
            $action = route('admin-points-bad-words-add');
            $method = 'post';
        }

        $fmForm = new FmForm(
            'PointsBadWordsFrm',
            $action,
            $method,
            ['class' => 'smart-form', 'novalidate' => 'novalidate'],
            true
        );
        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);

        // Get edit from data in case of edit record
        if ($id) {
            $data = PointsBadWords::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');
        }

        $fmForm
            ->add([
                    "col" => 12,
                    "type" => "text",
                    "name" => "title",
                    "label" => "Title",
                    "value" => (isset($data->title) ? $data->title : ""),
            ])
            ->add(array(
                "col" => 12,
                "type" => "select",
                "options" => ['1' => 'Active', '0' => 'Inactive'],
                "name" => "is_active",
                "label" => "Select Status",
                "value" => (isset($data->is_active) ? $data->is_active : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
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
        $this->pageData['SubNav'] = "Add Points Bad Word";
        $this->pageData['MainHeading'] = $this->singularName . " Detail";
        $detailData = [];
        $detailData = PointsBadWords::Select(
            'id as ID',
            'title as Title',
            \DB::Raw('
            CASE
                WHEN is_active = 1 THEN "Active"
                ELSE "Inactive"
            END AS Status
            '),
            'created_at as Created Date Time',
            'updated_at as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['Points Bad Words'] = $detailData['Title'];
        $detailData['Title'] = "<code>" . htmlentities($detailData['Title']) . "</code>";

        return view('admin.detail')->with(['pageData' => $this->pageData])->with(compact('detailData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->pageData['MainHeading'] = "Add " . $this->singularName;
        $this->pageData['PageTitle'] = "Add " . $this->singularName;
        $this->pageData['SubNav'] = "Add Bad Word";
        $this->pageData['NavHeading'] = "New Bad Word";

        // Js form validation
        $jsValidator = JsValidator::make($this->validationRules);

        // Add  User Form
        $form = $this->form();

        return view('admin.add')
            ->with(['pageData' => $this->pageData])
            ->with(compact('form'))
            ->with(compact('jsValidator'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), $this->validationRules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        try {
            $data = PointsBadWords::create([
                'title' => $request['title'],
                'is_active' => $request['is_active']
            ]);

            if ($data->id) {
                $request->session()->flash('alert-success', 'Bad word has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->back();
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
    public function update(PointsBadWordsRequest $request, $id)
    {
        // Update Backend User
        try {
            $updateRecord = PointsBadWords::find($id);
            $updateRecord->title = $request->title;
            $updateRecord->is_active = $request->is_active;
            $updateRecord->updated_at = time();

            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->route("admin-points-bad-words-list");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Delete Backend User
        try {
            $badWord = PointsBadWords::find($id);
            if ($badWord->delete()) {
                $request->session()->flash('alert-success', 'Bad word has been deleted successfully!');
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
        } else { // All and Custom Case
            $columns = ['*'];
        }

        $badWords = PointsBadWords::select($columns);
        $table = DataTables::of($badWords);
        $table->addColumn('action', function ($badWords) {
            return '
                <a href="' . route('admin-points-bad-words-edit', $badWords->id) . '" class="btn btn-xs btn-primary" 
                    rel="tooltip" data-placement="top" data-original-title="Edit">
                    <i class="glyphicon glyphicon-edit"></i>
                </a> 
                <a href="' . route('admin-points-bad-words-detail', $badWords->id) . '" 
                    class="btn btn-xs bg-color-pink txt-color-white" 
                    rel="tooltip" data-placement="top" data-original-title="Detail">
                    <i class="glyphicon glyphicon-th-list"></i>
                </a>
                <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" 
                    onclick="confirmBox(\'' . route('admin-points-bad-words-delete', $badWords->id) . '\')">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            ';
        });

        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters) {
            setAdvanceFilter($request, $table);
        }

        return $table->make(true);
    }
}
