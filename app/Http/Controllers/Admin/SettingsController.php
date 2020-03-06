<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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


class SettingsController extends Controller
{
    protected $jsValidation = false;

    protected $validationRules = [];

    protected $pageData = array();

    public function __construct()
    {
        $this->pageData['PageTitle'] = "Settings";
        $this->pageData['MainNav'] = "Settings";
        $this->pageData['SubNav'] = "Manage Settings";

        // admin auth middleware
        $this->middleware('auth:admin');


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {


        $id = \Auth::user()->settings_string;

        $this->pageData['MainHeading'] = "Settings";

        $this->validationRules = [
            'username' => "required|alpha_dash|unique:backend_user,username,$id,user_id",
            'email' => "required|email|unique:backend_user,email,$id,user_id",
            'name' => 'required',
            'avatar' => 'image',
            'timezone' => 'required',
        ];

        // Js form validation
        // $jsValidator = JsValidator::make($this->validationRules);

        // Settings From
        $form = $this->form();

        return view('admin.settings')
            ->with(['pageData' => $this->pageData])
            ->with(compact('form'))
            ->with(compact('jsValidator'));

    }

    public function form($id = "")
    {
        $data = array();

        $action = route('admin-settings-update', $id);
        $method = 'patch';

        $fmForm = new FmForm('SettingsFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New User');
        $fmForm->saveText('Update Settings');
        $fmForm->jsValidation($this->jsValidation);


        // Get edit from data in case of edit record
        $detailData = $data = array();
        $data = \Auth::user();

        $detailData = Admin::Select('settings_string')->Find($data->user_id)->toArray();
        if (isset($detailData['settings_string']) && !empty($detailData['settings_string'])):
            $data->settings_string = \GuzzleHttp\json_decode($detailData['settings_string']);
        endif;


        $fmForm
            ->add(array(
                "col" => 12,
                "type" => "html",
                "html" => "<h5>User Info</h5><hr/>"
            ))
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
                "value" => (isset($data->email) ? $data->email : ""),
            ))
            ->add(array(
                "type" => "text",
                "name" => "username",
                "label" => "Username",
                "value" => (isset($data->username) ? $data->username : ""),
            ))
            ->add(array(
                "type" => "select",
                "options" => timezone_list(),
                "name" => "timezone",
                "label" => "timezone",
                "value" => (isset($data->timezone) ? $data->timezone : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 12,
                "type" => "html",
                "html" => "<h5>Password</h5><hr/>"
            ))
            ->add(array(
                "col" => 12,
                "type" => "password",
                "icon" => "fa-unlock-alt",
                "name" => "password",
                "label" => "Password",
                "value" => ""
            ))
            ->add(array(
                "col" => 12,
                "type" => "html",
                "html" => "<h5></h5><hr/>"
            ))
            ->add(array(
                "col" => (isset($data->avatar) ? 11 : 12),
                "type" => "file",
                "name" => "avatar",
                "label" => "Upload Avatar",
                "value" => isset($data->avatar) ? getAvatar($data->avatar) : ""
            ))
            ->add(array(
                "col" => 12,
                "type" => "html",
                "html" => "<h5></h5><hr/>"
            ))
            ->add(array(
                "type" => "checkbox-toggle",
                "name" => "save_filter",
                "label" => "Save search filters",
                "value" => (isset($data->settings_string->save_filter) ? $data->settings_string->save_filter : ""),
            ))
            ->add(array(
                "type" => "select",
                "options" => getListingUrls(),
                "name" => "redirect_after_login",
                "label" => "User redirect after logged in",
                "value" => (isset($data->settings_string->redirect_after_login) ? $data->settings_string->redirect_after_login : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ));


        return $fmForm->getForm();

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        // Update user
        try {

            //Logged User ID
            $id = \Auth::user()->user_id;


            //Update Rules
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


            $settingData = $request->toArray();
            unset($settingData['_method']);
            unset($settingData['_token']);


            $settingData = [];
            $settingData['save_filter'] = $request->save_filter;
            $settingData['redirect_after_login'] = $request->redirect_after_login;
            $settingData = (\GuzzleHttp\json_encode($settingData));


            $updateRecord = Admin::find($id);
            $updateRecord->name = $request->name;
            $updateRecord->email = $request->email;
            $updateRecord->username = $request->username;
            $updateRecord->timezone = $request->timezone;
            $updateRecord->settings_string = $settingData;
            $updateRecord->updated_timestamp = time();

            // File upload here
            $fileName = '';
            $file = $request->file('avatar');
            if ($file) {
                //Move Uploaded File
                $fileName = "avatar_" . time() . "." . $file->guessExtension();
                $destinationPath = 'assets/admin/uploads/avatars';
                $file->move($destinationPath, $fileName);
                $updateRecord->avatar = $fileName;
            }

            //if user update his password.
            if ($request->password)
                $updateRecord->password = bcrypt($request['password']);


            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', 'Settings has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateCustomViewColumns(Request $request, Admin $admin)
    {

        // Update user
        try {
            //Logged User ID
            $id = \Auth::user()->user_id;
            $data = [];
            $data['CustomList'] = $request->all();
            if ($admin->updateSettingsString($id, $data)) :
                $code = 200;
                $success = 'custom_view_column_updated_successfully';
                $message = 'The record has been updated successfully.';
                return response()->json(compact('code', 'success', 'message'));
            endif;

        } catch (\Exception $e) {
            return response()->json(['code' => 202, 'error' => 'invalid_fields_data', 'messages' => $e->getMessage()], 202);
        }


    }


}
