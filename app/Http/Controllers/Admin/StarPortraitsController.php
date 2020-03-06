<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StarRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\StarPortraits;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class StarPortraitsController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Star Portrait';
    public $pluralName = 'StarPortrait';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Star Portraits";

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
            ['data' => 'id', 'name' => 'id', 'title' => 'ID', 'searchable' => true, 'class' => 'text-center'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title', 'data-class' => 'expand', 'width' => 100],
            ['data' => 'left_image', 'name' => 'left_image', 'title' => 'Left Star', 'searchable' => false, 'class' => 'text-center no-filter'],
            ['data' => 'center_image', 'name' => 'center_image', 'title' => 'Center Star', 'searchable' => false, 'class' => 'text-center no-filter'],
            ['data' => 'right_image', 'name' => 'right_image', 'title' => 'Right Star', 'searchable' => false, 'class' => 'text-center no-filter'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'searchable' => true],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "Star_TBL", $viewColumns, 'Avatar', 'admin-star-list');

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

        $validationRules = [
            "title" => 'required',
            "status" => 'required',
            "left_image" => 'required',
            "center_image" => 'required',
            "right_image" => 'required',
        ];


        // Js form validation
        $jsValidator = JsValidator::make($validationRules);

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
            $action = route('admin-star-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-star-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('StarFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {


            $data = StarPortraits::find($id);
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
                    "type" => "text",
                    "name" => "title",
                    "label" => "Title",
                    "value" => (isset($data->title) ? $data->title : ""),
                )
            )
            ->add(array(
                "type" => "select",
                "options" => ['Active' => 'Active', 'Inactive' => 'Inactive'],
                "name" => "status",
                "label" => "Status",
                "value" => (isset($data['status']) ? $data['status'] : ""),
                "attr" => ['style' => 'width:100%', 'class' => '']
            ))
            ->add(array(
                "col" => (isset($data['left_image']) ? 3 : 4),
                "type" => "file",
                "name" => "left_image",
                "label" => "Star Left",
                "value" => (isset($data['left_image']) ? getStar($data['left_image']) : "")
            ))->add(array(
                "col" => (isset($data['center_image']) ? 3 : 4),
                "type" => "file",
                "name" => "center_image",
                "label" => "Star Center",
                "value" => (isset($data['center_image']) ? getStar($data['center_image']) : "")
            ))->add(array(
                "col" => (isset($data['right_image']) ? 3 : 4),
                "type" => "file",
                "name" => "right_image",
                "label" => "Star Right",
                "value" => (isset($data['right_image']) ? getStar($data['right_image']) : "")
            ));


        return $fmForm->getForm();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StarRequest $request)
    {
        $validationRules = [
            "title" => 'required',
            "status" => 'required',
            "left_image" => 'required',
            "center_image" => 'required',
            "right_image" => 'required',
        ];


        $validation = Validator::make($request->all(), $validationRules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        $leftStar = "";
        $centerStar = "";
        $rightStar = "";

        // File upload here
        $destinationPath = storage_path("stars");

        $file = $request->file('left_image');
        if ($file) {
            //Move Uploaded File
            $leftStar = "star_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $leftStar);
        }

        $file = $request->file('center_image');
        if ($file) {
            //Move Uploaded File
            $centerStar = "star_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $centerStar);
        }

        $file = $request->file('right_image');
        if ($file) {
            //Move Uploaded File
            $rightStar = "star_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $rightStar);
        }


        try {
            $data = StarPortraits::create([
                'title' => $request['title'],
                'left_image' => $leftStar,
                'center_image' => $centerStar,
                'right_image' => $rightStar,
                'status' => isset($request['status']) ? $request['status'] : 'Active',
                'created_timestamp' => time(),
                'updated_timestamp' => time()
            ]);

            if ($data->id) {


                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');

                return redirect()->to(route('admin-star-thumb', $data->id));


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

        $detailData = StarPortraits::Select(
            'id as ID',
            'status as Status',
            'title as Title',
            'left_image as left_image',
            'center_image as center_image',
            'right_image as right_image',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['left_image'] = getStar($detailData['left_image'], '');
        $detailData['center_image'] = getStar($detailData['center_image'], '');
        $detailData['right_image'] = getStar($detailData['right_image'], '');
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

        $validationRules = [
            "title" => 'required',
            "status" => 'required',
        ];


        // Js form validation
        $jsValidator = JsValidator::make($validationRules);

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
    public function update(StarRequest $request, $id)
    {


        $validationRules = [
            "title" => 'required',
            "status" => 'required',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }


        $leftStar = "";
        $centerStar = "";
        $rightStar = "";

        // File upload here
        $destinationPath = storage_path("stars");

        $file = $request->file('left_image');
        if ($file) {
            //Move Uploaded File
            $leftStar = "star_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $leftStar);
        }

        $file = $request->file('center_image');
        if ($file) {
            //Move Uploaded File
            $centerStar = "star_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $centerStar);
        }

        $file = $request->file('right_image');
        if ($file) {
            //Move Uploaded File
            $rightStar = "star_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $rightStar);
        }


        // Update Backend User
        try {
            $updateRecord = StarPortraits::find($id);

            $updateRecord->status = $request->status;
            $updateRecord->title = $request->title;
            $updateRecord->updated_timestamp = time();

            if ($leftStar)
                $updateRecord->left_image = $leftStar;
            if ($centerStar)
                $updateRecord->center_image = $centerStar;
            if ($rightStar)
                $updateRecord->right_image = $rightStar;


            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->route("admin-star-list");

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
            $user = StarPortraits::find($id);
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


        $apps = StarPortraits::select($columns);

        $table = DataTables::of($apps);


        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-star-delete', $apps->id);

            return '<a href="' . route('admin-star-edit', $apps->id) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="' . route('admin-star-detail', $apps->id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="glyphicon glyphicon-th-list"></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i> </a>
                    <a href="' . route('admin-star-thumb', $apps->id) . '" class="btn btn-xs bg-color-green txt-color-white" rel="tooltip" data-placement="top" data-original-title="Edit Thumbnail"><i class="fa fa-picture-o"></i> </a>
                    ';
        });

        $table->editColumn('right_image', function ($user) {
            return getStar($user['right_image'], 'Star');
        });
        $table->editColumn('center_image', function ($user) {
            return getStar($user->center_image, 'Star');
        });
        $table->editColumn('left_image', function ($user) {
            return getStar($user->left_image, 'Star');
        });

        $table->editColumn('name', function ($user) {
            return ucwords($user->name);
        });

        $table->editColumn('is_author', function ($user) {
            return isset($user->is_author) && !empty($user->is_author) ? "Yes" : "No";
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
        $table->rawColumns(['left_image', 'right_image', 'center_image', 'action']);

        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editThumb($id)
    {
        $this->pageData['PageTitle'] = $this->singularName . " Detail";
        $this->pageData['SubNav'] = "Add " . $this->singularName;
        $this->pageData['MainHeading'] = $this->singularName . " Detail";


        $detailData = array();

        $detailData = StarPortraits::Select(
            'left_image as left_image',
            'center_image as center_image',
            'right_image as right_image'
        )->Find($id)->toArray();

        $detailData['left_image'] = storage_url($detailData['left_image'], "stars");
        $detailData['center_image'] = storage_url($detailData['center_image'], "stars");
        $detailData['right_image'] = storage_url($detailData['right_image'], "stars");


        return view('admin.edit-thumb')
            ->with(['pageData' => $this->pageData])
            ->with(compact('detailData'));;


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editThumbAction(Request $request, $id)
    {


        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $Array = ['cor_1', 'cor_2', 'cor_3'];

        $targ_w = $targ_h = 180;
        $jpeg_quality = 90;

        $i = 1;
        foreach ($Array as $img) {

            if (isset($request[$img]) && !empty($request[$img])) {
                $corData = [];
                $corData = \GuzzleHttp\json_decode($request[$img], true);
                $src = $request["img_" . $i];
                $newThumbPath = "";

                if ($src) {
                    $pathinfo = pathinfo($src);
                    $newThumbName = "thumb_" . $pathinfo["filename"] . "." . $pathinfo["extension"];
                    $newThumbPath = storage_path("stars" . "/" . $newThumbName);
                }

                $src = str_replace("http://storystar.com/", "", $src);
                $src = str_replace("https://www.storystar.com/", "", $src);
                $src = str_replace("http://www.storystar.com/", "", $src);

                $img_r = imagecreatefromjpeg($src);
                $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

                imagecopyresampled($dst_r, $img_r, 0, 0, $corData['x'], $corData['y'],
                    $targ_w, $targ_h, $corData['w'], $corData['h']);

                imagejpeg($dst_r, $newThumbPath, $jpeg_quality);


            }
            $i++;
        }


        $request->session()->flash('alert-success', 'Thumbnail has been created successfully!');
        return redirect()->route("admin-star-list");


    }


}
