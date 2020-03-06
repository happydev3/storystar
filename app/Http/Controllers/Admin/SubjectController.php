<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubjectRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Subject;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class SubjectController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Subject';
    public $pluralName = 'Subjects';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Subjects";

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
            ['data' => 'subject_id', 'name' => 'subject_id', 'title' => 'Subject ID', 'searchable' => true, 'class' => 'text-center', 'width' => 50],
            ['data' => 'subject_title', 'name' => 'subject_title', 'title' => 'Title', 'data-class' => 'expand', 'width' => 200],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "Subject_TBL", $viewColumns, 'Avatar', 'admin-subject-list');

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
        $this->pageData['SubNav'] = "Add ".$this->singularName;
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
            $action = route('admin-subject-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-subject-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('SubjectFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {

            $data = Subject::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');

            $updatedAppFiled =
                [
                    //"attr" => ['readonly' => 'readonly'],
                    //"tooltip" => "You can't change the Field."
                ];
        }

        $subjectOrderOptions = [];

        $total = Subject::all()->count();
        for ($i = 0; $i < $total; $i++) {
            $subjectOrderOptions[$i] = $i;
        }

        $fmForm
            ->add(array(
                    "col" => 12,
                    "type" => "text",
                    "name" => "subject_title",
                    "label" => "Title",
                    "value" => (isset($data->subject_title) ? $data->subject_title : ""),
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
    public function store(SubjectRequest $request)
    {


        try {
            $data = Subject::create([
                'subject_title' => $request['subject_title'],
                'created_timestamp' => time(),
                'updated_timestamp' => time()
            ]);

            if ($data->subject_id) {
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
        $this->pageData['SubNav'] = "Add ".$this->singularName;
        $this->pageData['MainHeading'] = $this->singularName . " Detail";

        $detailData = array();

        $detailData = Subject::Select(
            'subject_id as ID',
            'subject_title as Subject Title',
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
    public function update(SubjectRequest $request, $id)
    {


        // Update Backend User
        try {
            $updateRecord = Subject::find($id);

            $updateRecord->subject_title = $request->subject_title;
            $updateRecord->updated_timestamp = time();


            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->route("admin-subject-list");

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
            $user = Subject::with("stories")->find($id);

            if ($user->stories->count() >= 1) {
                $request->session()->flash('alert-danger', 'Some stories belong to this subject. So you need to delete the stories first before delete this subject');
            } else {
                if ($user->delete()) {
                    $request->session()->flash('alert-success', $this->singularName . ' has been deleted successfully!');
                } else {
                    $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
                }
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
            if (in_array('action', $this->listViewSimple))
                $this->listViewSimple = array_diff($this->listViewSimple, array('action'));
            $columns = $this->listViewSimple;

        } else
            // All and Custom Case
            $columns = ['*'];


        $apps = Subject::select($columns);

        $table = DataTables::of($apps);


        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-subject-delete', $apps->subject_id);

            return '<a href="' . route('admin-subject-edit', $apps->subject_id) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="' . route('admin-subject-detail', $apps->subject_id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="glyphicon glyphicon-th-list"></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i> </a>
                    ';
        });


        $table->editColumn('created_timestamp', function ($apps) {
            return my_date($apps->created_timestamp);
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
        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }
}
