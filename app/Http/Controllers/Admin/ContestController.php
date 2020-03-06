<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LinksRequest;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\ContestEntries;
use App\Models\Story;
use App\Models\Content;
use App\Models\StoryCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class ContestController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Contests';
    public $pluralName = 'Contests';
    protected $jsValidation = true;
    protected $listViewSimple = [];
    protected $selectedViewType = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Stories";

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
        $this->pageData['MainHeading'] = $this->singularName . ' Entries';

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
                'data' => 'user',
                'name' => 'user',
                'title' => 'User',
                'data-class' => 'expand',
                'width' => 200
            ],
            [
                'data' => 'nominated_by',
                'name' => 'nominated_by',
                'title' => 'Nominated By',
                'data-class' => 'expand',
                'width' => 200
            ],
            [
                'data' => 'story',
                'name' => 'story',
                'title' => 'Story',
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
                'data' => 'comments',
                'name' => 'comments',
                'title' => 'Comments',
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
            [
                'data' => 'is_approved',
                'name' => 'is_approved',
                'title' => 'Status',
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
            "PointsHistory_TBL",
            $viewColumns,
            'Avatar',
            'admin-contest-entries'
        );

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);
    }

    public function form($id = "", $callFrom = "")
    {
        $data = array();
        if ($id) {
            $action = route('admin-contest-update', $id);
            $method = 'patch';
        } else {
            $action = route('admin-contest-add');
            $method = 'post';
        }

        $fmForm = new FmForm(
            'LinksFrm',
            $action,
            $method,
            ['class' => 'smart-form', 'novalidate' => 'novalidate'],
            true
        );

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);
        $fmForm->setter(['removeCancel' => true]);

        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {
            $data = Content::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');
            $updatedFields = ["tooltip" => "You can't change the Field."];
        }

        $fmForm
            ->add(
                array(
                    "col" => 12,
                    "type" => "textarea",
                    "name" => "content",
                    "attr" => ["rows" => 30],
                    "label" => "Link Content",
                    "value" => (isset($data->content) ? $data->content : ""),
                )
            )
            ->add(
                array(
                    "col" => 12,
                    "type" => "html",
                    "html" => "<hr/>",
                )
            );

        return $fmForm->getForm();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $callFrom = '')
    {
        $this->pageData['MainHeading'] = "Edit " . $this->singularName;
        $this->pageData['PageTitle'] = "Edit " . $this->singularName;
        $this->pageData['SubNav'] = "Edit Contest";
        $this->pageData['NavHeading'] = "Edit " . $this->singularName;

        $form = $this->form($id, $callFrom);
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
    public function update(LinksRequest $request, $id)
    {
        // Update Backend User
        try {
            $updateRecord = Content::find($id);
            $updateRecord->content = $request['content'];
            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->route("admin-contest-edit", ["id" => $id]);
    }

    /**
     * Approve the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        try {
            ContestEntries::where(['id' => $id])->update(['is_approved' => 1]);
            $request->session()->flash('alert-success', 'Record approved successfully!');
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }

    public function getAjaxData($request)
    {
        if ($this->selectedViewType == 'simple') {
            // Remove action column for query
            if (in_array('action', $this->listViewSimple)) {
                $this->listViewSimple = array_diff($this->listViewSimple, array('action'));
            }
            $columns = $this->listViewSimple;
        } else { // All and Custom Case
            $columns = ['*'];
        }

        $apps = ContestEntries::select([
            'contest_entries.id',
            'users.name as user',
            'nominated_users.name as nominated_by',
            'stories.story_title as story',
            'contest_entries.points',
            'contest_entries.comments',
            \DB::Raw('
                (
                CASE WHEN contest_entries.is_approved = 0 THEN "Un Approved"
                ELSE "Approved"
                END
                ) AS is_approved
            '),
            'contest_entries.created_at as created_at'
        ])
        ->leftJoin('users', 'users.user_id', '=', 'contest_entries.user_id')
        ->leftJoin('users as nominated_users', 'nominated_users.user_id', '=', 'contest_entries.nominated_by')
        ->leftJoin('stories', 'stories.story_id', '=', 'contest_entries.story_id')
        ->orderBy("contest_entries.id", "desc");

        $table = DataTables::of($apps);
        $table->addColumn('action', function ($apps) {
            if ($apps->is_approved != 'Approved') {
                return '
                    <a href="javascript:void(0)"  class="btn btn-xs btn-success txt-color-white" 
                        onclick="confirmBoxApprove(\'' . route('admin-contest-approve-entry', $apps->id) . '\')">
                        <i class="glyphicon glyphicon-check"></i>
                    </a>
                ';
            } else {
                return '
                    <a href="javascript:void(0)"  class="btn btn-xs btn-info txt-color-white">
                        <i class="glyphicon glyphicon-check"></i>
                    </a>
                ';
            }
        });
        $table->filterColumn('user', function ($query, $keyword) {
            $query->whereRaw("users.name like ?", ["%$keyword%"]);
        });
        $table->filterColumn('nominated_by', function ($query, $keyword) {
            $query->whereRaw("nominated_users.name like ?", ["%$keyword%"]);
        });
        $table->filterColumn('story', function ($query, $keyword) {
            $query->whereRaw("stories.story_title like ?", ["%$keyword%"]);
        });
        $table->filterColumn('is_approved', function ($query, $keyword) {
            if ($keyword == 'approved') {
                $query->where("contest_entries.is_approved", 1);
            } else {
                $query->where("contest_entries.is_approved", 0);
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
