<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Ads;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class AdsController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Google Ads';
    public $pluralName = 'Google Ads';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;


    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Ads";

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
            ['data' => 'id', 'name' => 'id', 'title' => 'ID', 'searchable' => false, 'class' => 'text-center', "width" => 100],
            ['data' => 'page_name', 'name' => 'page_name', 'title' => 'Page', 'searchable' => true, 'class' => 'text-center'],
            ['data' => 'updated_timestamp', 'name' => 'updated_timestamp', 'title' => 'Update On', 'data-class' => 'expand', 'width' => 200],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "User_TBL", $viewColumns, 'Avatar', 'admin-ads-list');


        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);

    }


    public function form($id = "")
    {


        $data = array();
        if ($id):
            $action = route('admin-ads-update', $id);

            $method = 'patch';
        else:
            $action = route('admin-ads-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('AdsFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {
            $data = Ads::find($id);
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
                "name" => "ads_code",
                "label" => "ads_code",
                "value" => (isset($data->ads_code) ? $data->ads_code : ""),

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

        $detailData = Ads::Select(
            'id as User ID',
            'page_name as Page Name',
            'ads_code as Ads Code',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'


        )->Find($id)->toArray();

        $detailData['Ads'] = $detailData['Ads Code'];
        $detailData['Ads Code'] = "<code>" . htmlentities($detailData['Ads Code']) . "</code>";
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
    public function update(AdsRequest $request, $id)
    {

        // Update Backend User
        try {
            $updateRecord = Ads::find($id);
            $updateRecord->ads_code = $request->ads_code;
            $updateRecord->updated_timestamp = time();

            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->route("admin-ads-list");

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


        $apps = Ads::select($columns);

        $table = DataTables::of($apps);


        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-ads-delete', $apps->id);
            $blockUserURL = route('admin-ads-block', $apps->id);

            $blockTooltip = "";
            if ($apps->active == 1) {
                $blockTooltip = "Block User";

            } else {
                $blockTooltip = "Unblock User";
            }

            return '<a href="' . route('admin-ads-edit', $apps->id) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="' . route('admin-ads-detail', $apps->id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="glyphicon glyphicon-th-list"></i> </a>
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
