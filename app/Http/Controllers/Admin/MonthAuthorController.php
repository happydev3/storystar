<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MonthAuthorRequest;
use App\Models\PointsHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\MonthAuthor;
use App\Models\SiteUser;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class MonthAuthorController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Author of Month';
    public $pluralName = 'Authors of Month';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Author of Month List";

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
                'searchable' => true,
                'class' => 'text-center',
                'width' => 100
            ],
            /*[
                'data' => 'month',
                'name' => 'month',
                'title' => 'Month',
                'data-class' => 'expand',
                'width' => 150
            ],*/
            [
                'data' => 'avatar',
                'name' => 'avatar',
                'title' => 'Avatar',
                'searchable' => false,
                'class' => 'text-center no-filter'
            ],
            [
                'data' => 'name',
                'name' => 'name',
                'title' => 'Author',
                'searchable' => true,
                'class' => 'text-left'
            ],
            [
                'data' => 'created_timestamp',
                'name' => 'created_timestamp',
                'title' => 'Created Date',
                'data-hide' => 'phone',
                'width' => '150px'
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

        $html = $this->getDataTable($builder, "Star_TBL", $viewColumns, 'Avatar', false, [[0, "desc"]]);
        //  $html = $this->getDataTable($builder, "Comment_TBL", $viewColumns, 'Avatar', false, [[0, "desc"]]);

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

    public function form($id = "")
    {
        $data = array();
        if ($id):
            $action = route('admin-month-author-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-month-author-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm(
            'MonthAuthorFrm',
            $action,
            $method,
            ['class' => 'smart-form', 'novalidate' => 'novalidate'],
            true
        );
        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);

        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {
            $data = MonthAuthor::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');
            $updatedAppFiled = [
                //"attr" => ['readonly' => 'readonly'],
                //"tooltip" => "You can't change the Field."
            ];
        }

        $user = SiteUser::select(\DB::raw("CONCAT(name, ' - [',email,']') AS name"), 'user_id')
            ->orderBy("name", "asc")
            ->where("is_author", "=", 1)
            ->get()
            ->toArray();

        $user = array_combine(array_column($user, 'user_id'), array_column($user, 'name'));

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F Y', mktime(0, 0, 0, $m, 1, date('Y')));
            $months[date('Y-m-d', mktime(0, 0, 0, $m, 1, date('Y')))] = $month;
        }

        $fmForm
            ->add(array(
                "type" => "select",
                "options" => $user,
                "name" => "user_id",
                "label" => "Author",
                "value" => (isset($data['user_id']) ? $data['user_id'] : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "type" => "select",
                "options" => $months,
                "name" => "month",
                "label" => "Month",
                "value" => (isset($data['month']) ? $data['month'] : ""),
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
    public function store(MonthAuthorRequest $request)
    {
        try {
            PointsHistory::selectAuthorOfMonth($request);
            $data = MonthAuthor::create([
                'user_id' => $request['user_id'],
                'month' => $request['month'],
                'created_timestamp' => time(),
                'updated_timestamp' => time()
            ]);

            if ($data->id) {
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
        $detailData = MonthAuthor::select([
            'month_author.id AS ID',
            'users.name AS Author',
            'month_author.user_id AS Author ID',
            'month_author.month AS Month',
            'month_author.created_timestamp AS Created Date Time',
            'month_author.updated_timestamp AS Updated Date Time',
            'users.user_id AS Author ID',
            // 'users.avatar'
        ])
        ->join('users', 'users.user_id', '=', 'month_author.user_id')->Find($id);

        if (!isset($detailData) || empty($detailData)) {
            return abort(404);
        }

        $detailData = $detailData->toArray();
        $detailData['Author'] = $detailData['Author'];
        $detailData['Author ID'] = $detailData['Author ID'];
        $detailData['Created Date Time'] = my_date($detailData['Created Date Time'], '', '');
        $detailData['Updated Date Time'] = my_date($detailData['Updated Date Time'], '', '');

        // dd($detailData);
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
        $this->pageData['SubNav'] = "AddApp";
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
    public function update(MonthAuthorRequest $request, $id)
    {
        // Update Backend User
        try {
            $updateRecord = MonthAuthor::find($id);
            $updateRecord->user_id = $request['user_id'];
            $updateRecord->month = $request->month;
            $updateRecord->updated_timestamp = time();

            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }
        return redirect()->route("admin-month-author-list");
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
            $user = MonthAuthor::find($id);
            if ($user->delete()) {
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
        } else { // All and Custom Case
            $columns = ['*'];
        }

        $data = MonthAuthor::with('user')
            ->select(['month_author.*', 'users.name', 'users.avatar',])
            ->join('users', 'users.user_id', '=', 'month_author.user_id');

        $table = DataTables::of($data);
        $table->addColumn('action', function ($data) {
            $deleteURL = route('admin-month-author-delete', $data->id);
            /*<a href="' . route('admin-month-author-edit', $data->id) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit">
                <i class="glyphicon glyphicon-edit"></i>
            </a>
            <a href="' . route('admin-month-author-detail', $data->id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail">
                <i class="glyphicon glyphicon-th-list"></i>
            </a>*/

            return '
                <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" 
                onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" 
                data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i></a>
            ';
        });

        $table->editColumn('avatar', function ($data) {
            return getUserAvatar($data->avatar, $data->name);
        });
        $table->editColumn('name', function ($data) {
            return ucwords($data->name);
        });
        $table->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("users.name like ?", ["%$keyword%"]);
        });
        $table->editColumn('created_timestamp', function ($data) {
            return my_date($data->created_timestamp);
        });
        $table->filterColumn('created_timestamp', function ($query, $keyword) {
            $query->whereRaw(
                "DATE_FORMAT(FROM_UNIXTIME(created_timestamp),' % d -%m -%Y % h:%i:%s') like ?",
                ["%$keyword%"]
            );
        });
        $table->editColumn('updated_timestamp', function ($data) {
            return my_date($data->updated_timestamp);
        });
        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
            $query->whereRaw(
                "DATE_FORMAT(FROM_UNIXTIME(updated_timestamp),' % d -%m -%Y % h:%i:%s') like ?",
                ["%$keyword%"]
            );
        });
        $table->rawColumns(['avatar', 'action']);

        //If custom Filter Added.
        if ($this->advanceFilters) {
            setAdvanceFilter($request, $table);
        }

        return $table->make(true);
    }

    public function updateAuthorFromMemberList(Request $request)
    {
        if ($request->user_id) {
            try {
                PointsHistory::selectAuthorOfMonth($request);
                $data = MonthAuthor::create([
                    'user_id' => $request->user_id,
                    'month' => date("Y-m-d"),
                    'created_timestamp' => time(),
                    'updated_timestamp' => time()
                ]);

                if ($data->id) {
                    $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
                } else {
                    $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
                }
            } catch (\Exception $e) {
                $request->session()->flash('alert-danger', $e->getMessage());
            }
            return redirect()->back();
        }
    }
}
