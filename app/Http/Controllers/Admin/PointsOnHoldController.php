<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\PointsOnHold;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class PointsOnHoldController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Points - On Holds';
    public $pluralName = 'Points - On Hold';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_at', 'action'];
    protected $selectedViewType = false;
    protected $validationRules = ['is_approved' => 'required'];

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Points On Holds";

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
                'data' => 'name',
                'name' => 'name',
                'title' => 'User',
                'searchable' => true,
                'class' => 'text-center'
            ],
            [
                'data' => 'title',
                'name' => 'title',
                'title' => 'Story / Blog',
                'searchable' => true,
                'class' => 'text-center'
            ],
            [
                'data' => 'action_type',
                'name' => 'action_type',
                'title' => 'Action Type',
                'searchable' => true,
                'class' => 'text-center'
            ],
            [
                'data' => 'reason',
                'name' => 'reason',
                'title' => 'Reason',
                'searchable' => true,
                'class' => 'text-center'
            ],
            [
                'data' => 'is_approved',
                'name' => 'is_approved',
                'title' => 'Status',
                'searchable' => true,
                'class' => 'text-center'
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => 'Created On',
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
            "PointsOnHold_TBL",
            $viewColumns,
            'Avatar',
            'admin-points-on-hold-list'
        );

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);
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
            $badWord = PointsOnHold::find($id);
            if ($badWord->delete()) {
                $request->session()->flash('alert-success', 'Record deleted successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Approve the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        // Delete Backend User
        try {
            PointsOnHold::approve($id);
            $request->session()->flash('alert-success', 'Record approved successfully!');
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }

    public function getAjaxData($request)
    {
        $apps = PointsOnHold::select(
            [
                'points_on_hold.id',
                'users.name',
                'users.email',
                \DB::Raw('
                CASE
                    WHEN stories.story_title IS NULL THEN blogs.title
                    ELSE stories.story_title
                END AS title
                '),
                'points_category.description AS action_type',
                'points_on_hold.reason as reason',
                \DB::Raw('
                CASE
                    WHEN points_on_hold.is_approved = 1 THEN "Approved"
                    ELSE "Un Approved"
                END AS is_approved
                '),
                'points_on_hold.created_at as created_at',
            ]
        )
        ->join('users', 'users.user_id', '=', 'points_on_hold.user_id')
        ->leftJoin('stories', function ($join) {
            $join->on('stories.story_id', '=', 'points_on_hold.action_id')
            ->where('points_on_hold.action_type', "=", "post_comment");
        })
        ->leftJoin('blogs', function ($join) {
            $join->on('blogs.id', '=', 'points_on_hold.action_id')
            ->where('points_on_hold.action_type', "=", "blog_reply");
        })
        ->leftJoin('points_category', function ($join) {
            $join->on('points_category.name', '=', 'points_on_hold.action_type')
            ->where('points_category.is_active', "=", 1);
        })
        ->where('is_approved', '<>', 1)
        ->orderBy("points_on_hold.id", "desc");

        $table = DataTables::of($apps);
        $table->addColumn('action', function ($pointsOnHold) {
            return '
                <a href="javascript:void(0)"  class="btn btn-xs btn-success txt-color-white" 
                    onclick="confirmBoxApprove(\'' . route('admin-points-on-hold-approve', $pointsOnHold->id) . '\')">
                    <i class="glyphicon glyphicon-check"></i>
                </a>
                <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" 
                    onclick="confirmBox(\'' . route('admin-points-on-hold-delete', $pointsOnHold->id) . '\')">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            ';
        });
        $table->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("users.name like ?", ["%$keyword%"]);
        });
        $table->filterColumn('email', function ($query, $keyword) {
            $query->whereRaw("stories.story_title like ?", ["%$keyword%"]);
            $query->orWhereRaw("blogs.title like ?", ["%$keyword%"]);
        });
        $table->filterColumn('title', function ($query, $keyword) {
            $query->whereRaw("users.email like ?", ["%$keyword%"]);
        });
        $table->filterColumn('action_type', function ($query, $keyword) {
            $query->whereRaw("points_category.description like ?", ["%$keyword%"]);
        });
        $table->filterColumn('is_approved', function ($query, $keyword) {
            if ($keyword == 'approved') {
                $query->where("points_on_hold.is_approved", 1);
            } else {
                $query->where("points_on_hold.is_approved", 0);
            }
        });

        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters) {
            setAdvanceFilter($request, $table);
        }

        return $table->make(true);
    }
}
