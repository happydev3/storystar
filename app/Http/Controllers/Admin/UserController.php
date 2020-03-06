<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Admin;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;


class UserController extends Controller
{

    protected $jsValidation = false;
    protected $selectedViewType = false;
    protected $listViewSimple = ['name', 'created_timestamp', 'updated_timestamp', 'action'];
    protected $validationRules = [
        'username' => 'required|alpha_dash|unique:backend_user',
        'email' => 'required|email|unique:backend_user',
        'name' => 'required',
        'password' => 'required|min:6',
        'avatar' => 'image',
        'timezone' => 'required',
    ];


    public function __construct()
    {

        $this->pageData['PageTitle'] = "Members List";
        $this->pageData['MainNav'] = "Members";
        $this->pageData['SubNav'] = "Manage Members";

        // admin auth middleware
        $this->middleware('auth:admin');

    }

    public $singularName = 'Back-end Users';

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
            ['data' => 'avatar', 'name' => 'avatar', 'title' => 'Avatar', 'searchable' => false, 'class' => 'text-center'],
            ['data' => 'user_id', 'name' => 'user_id', 'title' => 'User ID', 'data-class' => 'expand', 'width' => '50px'],
            ['data' => 'name', 'name' => 'Name', 'title' => 'Name', 'searchable' => true],
            ['data' => 'username', 'name' => 'Username', 'title' => 'Username', 'data-hide' => 'phone'],
            ['data' => 'email', 'name' => 'Email', 'title' => 'Email', 'data-hide' => 'phone'],
            ['data' => 'created_timestamp', 'name' => 'created_timestamp', 'title' => 'Created Date', 'data-hide' => 'phone', 'width' => '150px'],
            ['data' => 'updated_timestamp', 'name' => 'updated_timestamp', 'title' => 'Updated Date', 'data-hide' => 'phone', 'width' => '150px'],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => true, 'footer' => '', 'class' => 'action-btn text-center','width'=>100]
        ];

        $html = $this->getDataTable($builder, "Backend_User_TBL", $viewColumns, 'Avatar', 'admin-member-list');


        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);

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
        $this->pageData['SubNav'] = "Add Member";
        $this->pageData['NavHeading'] = "New Back-end User";

        // Js form validation
        $jsValidator = JsValidator::make($this->validationRules);

        // Add  User Form
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

            $action = route('admin-member-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-member-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('BackEndUserFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New User');
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        // Get edit from data in case of edit record
        if ($id) {
            $data = Admin::find($id);

            $fmForm->add(array(
                "type" => "hidden",
                "name" => "user_id",
                "value" => (isset($data->user_id) ? $data->user_id : "")
            ));
            $fmForm->title('Update User');
            $fmForm->saveText('Update');

        }

        $fmForm
            ->add(array(
                "type" => "text",
                "icon" => "fa-user",
                "name" => "name",
                "label" => "Name",
                "value" => (isset($data->name) ? $data->name : ""),

            ))
            ->add(array(
                "type" => "email",
                "icon" => "fa-internet-explorer",
                "name" => "email",
                "label" => "Email",
                "value" => (isset($data['email']) ? $data['email'] : ""),
            ))
            ->add(array(
                "type" => "text",
                "name" => "username",
                "label" => "Username",
                "value" => (isset($data['username']) ? $data['username'] : ""),
            ))
            ->add(array(
                "type" => "password",
                "icon" => "fa-unlock-alt",
                "name" => "password",
                "label" => "Password",
                "value" => (isset($data['Password']) ? $data['Password'] : "")
            ))
            ->add(array(
                "type" => "select",
                "options" => timezone_list(),
                "name" => "timezone",
                "label" => "timezone",
                "value" => (isset($data['timezone']) ? $data['timezone'] : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => (isset($data['avatar']) ? 5 : 6),
                "type" => "file",
                "name" => "avatar",
                "label" => "Upload Avatar",
                "value" => (isset($data['avatar']) ? getAvatar($data['avatar']) : "")
            ));


        return $fmForm->getForm();

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

        // File upload here
        $fileName = '';
        $file = $request->file('avatar');
        if ($file) {

            //Move Uploaded File
            $fileName = "avatar_" . time() . "." . $file->guessExtension();
            $destinationPath = 'assets/admin/uploads/avatars';
            $file->move($destinationPath, $fileName);
        }


        // Insert Backend User
        try {
            $data = Admin::create([
                'name' => $request['name'],
                'username' => $request['username'],
                'password' => bcrypt($request['password']),
                'email' => $request['email'],
                'avatar' => $fileName,
                'created_timestamp' => time(),
                'updated_timestamp' => time()
            ]);

            if ($data->user_id) {
                $request->session()->flash('alert-success', 'Back-end user has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->back();//->route("admin-member-add");


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
        $this->pageData['SubNav'] = "Add Member";
        $this->pageData['MainHeading'] = "Member Detail";


        $detailData = array();
        $detailData = Admin::Select(
            'user_id as User ID',
            'username as Username',
            'email as Email',
            'name as Name',
            'avatar as Avatar',
            'timezone as Timezone',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['Created Date Time'] = my_date($detailData['Created Date Time'], '', '');
        $detailData['Updated Date Time'] = my_date($detailData['Updated Date Time'], '', '');
        $detailData['Avatar'] = getAvatar($detailData['Avatar'], $detailData['Name']);

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
    public  function edit($id)
    {

        $this->pageData['PageTitle'] = "Edit " . $this->singularName;
        $this->pageData['MainHeading'] = "Edit " . $this->singularName;
        $this->pageData['SubNav'] = "Add Member";
        $this->pageData['NavHeading'] = "Edit " . $this->singularName;

        $this->validationRules = [

            'username' => "required|alpha_dash|unique:backend_user,username,$id,user_id",
            'email' => "required|email|unique:backend_user,email,$id,user_id",
            'name' => 'required',
            'avatar' => 'image',
            'timezone' => 'required',
        ];

        // Js form validation
        $jsValidator = JsValidator::make($this->validationRules);

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
    public function update(Request $request, $id, Admin $admin)
    {
        $this->validationRules = [
            'username' => "required|alpha_dash|unique:backend_user,username,$id,user_id",
            'email' => "required|email|unique:backend_user,email,$id,user_id",
            'name' => 'required',
            'avatar' => 'image',
            'timezone' => 'required',
        ];

        $validation = Validator::make($request->all(), $this->validationRules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }


        // File upload here
        $fileName = '';
        $file = $request->file('avatar');
        if ($file) {

            //Move Uploaded File
            $fileName = "avatar_" . time() . "." . $file->guessExtension();
            $destinationPath = 'assets/admin/uploads/avatars';
            $file->move($destinationPath, $fileName);
        }


        // Update Backend User
        try {

            $updateRecord = Admin::find($id);
            $updateRecord->name = $request->name;
            $updateRecord->email = $request->email;
            $updateRecord->username = $request->username;
            $updateRecord->timezone = $request->timezone;
            $updateRecord->updated_timestamp = time();

            if ($fileName)
                $updateRecord->avatar = $fileName;

            if ($request->password)
                $updateRecord->password = bcrypt($request['password']);

            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', 'Back-end user has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->back();//->route("admin-member-add");

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
            $user = Admin::find($id);
            if ($user->delete()) {
                $request->session()->flash('alert-success', 'Back-end user has been deleted successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->back();//->route("admin-member-add");

    }

    public function getAjaxData($request)
    {
        // List Type Check On Get Data From DB
        if ($this->selectedViewType == 'simple') {
            // Remove action column for query
            if (in_array('action', $this->listViewSimple))
                $this->listViewSimple = array_diff($this->listViewSimple, array('action'));
            $columns = $this->listViewSimple;
			$users = Admin::select($columns);
        } else
            // All and Custom Case
            $columns = ['*'];
		$users = Admin::select($columns);
        //$users = Admin::select($columns);
        $table = DataTables::of($users);
        $table->editColumn('avatar', function ($user) {
            return getAvatar($user->avatar, $user->name);
        });
        $table->addColumn('action', function ($user) {
            return '<a href="' . route('admin-member-edit', $user->user_id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                            <a href="' . route('admin-member-detail', $user->user_id) . '" class="btn btn-xs bg-color-pink txt-color-white"><i class="glyphicon glyphicon-th-list"></i></a>
                            <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . route('admin-member-delete', $user->user_id) . '\')"><i class="glyphicon glyphicon-remove" ></i></a>';
        });
        $table->editColumn('created_timestamp', function ($user) {
            return my_date($user->created_timestamp, '', '');
        });
        $table->filterColumn('created_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(created_timestamp),'%d-%m-%Y %h:%i:%s') like ?", ["%$keyword%"]);
        });
        $table->editColumn('updated_timestamp', function ($user) {
            return my_date($user->updated_timestamp, '', '');
        });
        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(updated_timestamp),'%d-%m-%Y %h:%i:%s') like ?", ["%$keyword%"]);
        });

        $table->rawColumns(['avatar', 'action']);

        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }

    public function unsubscribe (){
      return 'test';
    }


}
