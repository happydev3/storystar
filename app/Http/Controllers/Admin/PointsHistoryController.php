<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PointsHistoryRequest;
use App\Models\PointsCategory;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\PointsHistory;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class PointsHistoryController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Points - History';
    public $pluralName = 'Points - History';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_at', 'updated_at', 'action'];
    protected $selectedViewType = false;
    protected $validationRules = ['points' => 'required'];

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage History";

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
                'data' => 'points_category',
                'name' => 'points_category',
                'title' => 'Category',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 200
            ],
            [
                'data' => 'user',
                'name' => 'user',
                'title' => 'For User',
                'data-class' => 'expand',
                'width' => 200
            ],
            [
                'data' => 'given_user',
                'name' => 'given_user',
                'title' => 'By User',
                'data-class' => 'expand',
                'width' => 200
            ],
            [
                'data' => 'points',
                'name' => 'points',
                'title' => 'Points',
                'data-class' => 'expand',
                'width' => 200
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => 'Created On',
                'data-class' => 'expand',
                'width' => 200
            ],
            /*[
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

        $html = $this->getDataTable(
            $builder,
            "PointsHistory_TBL",
            $viewColumns,
            'Avatar',
            'admin-points-history-list'
        );

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);
    }

    public function form($id = "")
    {
        $data = array();
        if ($id) {
            $action = route('admin-points-history-update', $id);
            $method = 'patch';
        } else {
            $action = route('admin-points-history-add');
            $method = 'post';
        }

        $fmForm = new FmForm(
            'PointsHistoryFrm',
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
            $data = PointsHistory::find($id);
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
            ->add(array(
                "col" => 12,
                "type" => "select",
                "options" => PointsCategory::dropdown(),
                "name" => "points_category",
                "label" => "Select Points Category",
                "value" => (isset($data->points_category) ? $data->points_category : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 12,
                "type" => "select",
                "options" => SiteUser::activeUsersDropdown(),
                "name" => "user_id",
                "label" => "Select User",
                "value" => (isset($data->user_id) ? $data->user_id : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ));

        return $fmForm->getForm();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->pageData['MainHeading'] = "Add/Remove Points";
        $this->pageData['PageTitle'] = "Add/Remove Points";
        $this->pageData['SubNav'] = "Add History";
        $this->pageData['NavHeading'] = "Add/Remove Points";

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
            $data = PointsHistory::addPoints(
                $request['points_category'],
                null,
                $request['user_id'],
                \Auth::user()->user_id,
                $request['points_category'] == 'remove' ? (-$request['points']) : $request['points']
            );

            $request->session()->flash('alert-success', 'Points have been added successfully!');
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
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
            $result = PointsHistory::removePoints($id);
            if ($result) {
                $request->session()->flash('alert-success', 'History has been deleted successfully!');
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
        $apps = PointsHistory::select(
            [
                'points_history.id',
                'points_category.description as points_category',
                'users1.name as user',
                \DB::Raw('
                    (
                    CASE WHEN users2.name IS NOT NULL THEN users2.name
                    ELSE "Admin"
                    END
                    ) AS given_user
                '),
                'points_history.points',
                'points_history.created_at as created_at'
            ]
        )
        ->leftJoin('users as users1', 'users1.user_id', '=', 'points_history.user_id')
        ->leftJoin('users as users2', 'users2.user_id', '=', 'points_history.given_user_id')
        ->leftJoin('points_category', function ($join) {
            $join->on('points_category.name', '=', 'points_history.action_type')
                ->where('points_category.is_active', "=", 1);
        })
        ->orderBy("points_history.id", "desc");

        $table = DataTables::of($apps);
        $table->addColumn('action', function ($points) {
            return '
                <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" 
                    onclick="confirmBox(\'' . route('admin-points-history-delete', $points->id) . '\')">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            ';
        });
        $table->filterColumn('user', function ($query, $keyword) {
            $query->whereRaw("users1.name like ?", ["%$keyword%"]);
        });
        $table->filterColumn('given_user', function ($query, $keyword) {
            $query->whereRaw("users2.name like ?", ["%$keyword%"]);
        });

        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters) {
            setAdvanceFilter($request, $table);
        }

        return $table->make(true);
    }
}
