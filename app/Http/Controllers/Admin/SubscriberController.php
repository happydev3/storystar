<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubscriberRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Subscribe;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class SubscriberController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Subscriber';
    public $pluralName = 'Subscriber';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;


    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Subscriberged Stories List";

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
            ['data' => 'id', 'name' => 'id', 'title' => 'ID', 'searchable' => true, 'class' => 'text-center', "width" => 100],
            ['data' => 'name', 'name' => 'name', 'title' => 'Subscriber Name', 'searchable' => true, 'class' => 'text-left'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Subscriber Email', 'searchable' => true, 'class' => 'text-left'],
            ['data' => 'updated_timestamp', 'name' => 'updated_timestamp', 'title' => 'Subscribed Date','searchable' => true, 'data-class' => 'expand', 'width' => 200],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "User_TBL", $viewColumns, 'Avatar', 'admin-subscriber-list');


        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);

    }

    public function destroy(Request $request, $id)
    {

        // Soft Delete Method
        try {
            $user = Subscribe::find($id);
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
            if (in_array('action', $this->listViewSimple))
                $this->listViewSimple = array_diff($this->listViewSimple, array('action'));
            $columns = $this->listViewSimple;

        } else
            // All and Custom Case
            $columns = ['*'];


        $apps = Subscribe::select($columns);

        $table = DataTables::of($apps);


        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-subscriber-delete', $apps->id);

            return '<a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i> </a>
                    ';
        });


        $table->editColumn('updated_timestamp', function ($apps) {
            return my_date($apps->updated_timestamp);
        });

        $table->filterColumn('updated_timestamp', function ($query, $keyword) {

            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(updated_timestamp), '%d-%m-%Y %h:%i:%s') like ? ", [" % $keyword % "]);
        });

        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }
}
