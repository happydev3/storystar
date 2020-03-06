<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PointsCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\PointsCategory;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class PointsCategoryController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Points - Categories';
    public $pluralName = 'Points - Category';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_at', 'updated_at', 'action'];
    protected $selectedViewType = false;
    protected $validationRules = ['points' => 'required'];

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Categories";

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
                'data' => 'description',
                'name' => 'description',
                'title' => 'Description',
                'searchable' => true,
                'class' => 'text-center'
            ],
            [
                'data' => 'points',
                'name' => 'points',
                'title' => 'Points',
                'searchable' => true,
                'class' => 'text-center'
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
            "PointsCategory_TBL",
            $viewColumns,
            'Avatar',
            'admin-points-category-list'
        );

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);
    }

    public function form($id = "")
    {
        $data = array();
        if ($id) {
            $action = route('admin-points-category-update', $id);
            $method = 'patch';
        }

        $fmForm = new FmForm(
            'PointsCategoryFrm',
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
            $data = PointsCategory::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');
        }

        $fmForm
            ->add([
                "col" => 12,
                "type" => "text",
                "name" => "points",
                "label" => "Points",
                "value" => (isset($data->points) ? $data->points : ""),
            ])
            ->add([
                "col" => 12,
                "type" => "text",
                "name" => "description",
                "label" => "Description",
                "value" => (isset($data->description) ? $data->description : ""),
                "readonly" => "readonly"
            ]);


        return $fmForm->getForm();
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
    public function update(PointsCategoryRequest $request, $id)
    {
        // Update Backend User
        try {
            $updateRecord = PointsCategory::find($id);
            $updateRecord->points = $request->points;
            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->route("admin-points-category-list");
    }

    public function getAjaxData($request)
    {
        $apps = PointsCategory::select([
                'points_category.id',
                'points_category.points',
                'points_category.description',
        ])
        ->orderBy("points_category.id", "desc")
        ->where('points_category.is_displayed', 2);

        $table = DataTables::of($apps);
        $table->addColumn('action', function ($points) {
            return '
                <a href="' . route('admin-points-category-edit', $points->id) . '" class="btn btn-xs btn-primary" 
                    rel="tooltip" data-placement="top" data-original-title="Edit">
                    <i class="glyphicon glyphicon-edit"></i>
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
