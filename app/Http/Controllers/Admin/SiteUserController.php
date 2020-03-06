<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SiteUserRequest;
use App\Http\Requests\SendEmailRequest;
use App\Models\FavoriteAuthor;
use App\Models\BlockedIpAddress;
use App\Models\FavoriteStory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\SiteUser;
use App\Models\Story;
use App\Models\Comment;
use App\Models\StoryStar;
use App\Models\MonthAuthor;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

use App\Notifications\BlockedUserNotification;
use App\Notifications\EmailToUserNotification;

class SiteUserController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Site Member';
    public $pluralName = 'Site Members';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;
    protected $multipleDelete = true;
    protected $advanceFilters = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Site User";

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

        $viewColumns = [
            [
                'data' => 'user_id',
                'name' => 'user_id',
                'title' => '',
                'searchable' => true,
                'class' => 'text-center no-filter',
                'width' => 30
            ],
            [
                'data' => 'avatar',
                'name' => 'avatar',
                'title' => 'Avatar',
                'searchable' => false,
                'class' => 'text-center no-filter',
                'width' => 40
            ],
            [
                'data' => 'user_id',
                'name' => 'user_id',
                'title' => 'User ID',
                'searchable' => true,
                'class' => 'text-center',
                'width' => 30
            ],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'searchable' => true, 'width' => 150],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'searchable' => true, 'width' => 210],
            [
                'data' => 'active',
                'name' => 'active',
                'title' => 'AC',
                'data-class' => 'expand',
                'class' => 'text-center yes-no',
                'width' => 10
            ],
            [
                'data' => 'is_author',
                'name' => 'is_author',
                'title' => 'AU',
                'searchable' => true,
                'data-class' => 'expand',
                'class' => 'text-center yes-no',
                'width' => 10
            ],
            [
                'data' => 'is_profile_complete',
                'name' => 'is_profile_complete',
                'title' => 'P',
                'data-class' => 'expand',
                'class' => 'text-center  yes-no',
                'width' => 10
            ],
            [
                'data' => 'is_blocked',
                'name' => 'is_blocked',
                'title' => 'B',
                'data-class' => 'expand',
                'class' => 'text-center  yes-no',
                'width' => 10
            ],
            [
                'data' => 'gender',
                'name' => 'gender',
                'title' => 'G',
                'searchable' => true,
                'data-class' => 'expand',
                'class' => 'text-center',
                'width' => 10
            ],
            [
                'data' => 'country',
                'name' => 'country',
                'title' => 'Country',
                'data-class' => 'expand',
                'width' => 100,
                'class' => 'text-center countries'
            ],
            [
                'data' => 'story_count',
                'name' => 'story_count',
                'title' => 'S',
                'data-class' => 'expand',
                'width' => 100,
                'class' => 'text-center',
                'width' => 10
            ],
            [
                'data' => 'points',
                'name' => 'points',
                'title' => 'Pts',
                'data-class' => 'expand',
                'width' => 100,
                'class' => 'text-center',
                'width' => 10
            ],
            [
                'data' => 'is_premium',
                'name' => 'is_premium',
                'title' => '<i class="fa fa-credit-card"></i>',
                'data-class' => 'expand',
                'class' => 'text-center  yes-no',
                'width' => 10
            ],
            [
                'data' => 'premium_expiry_date',
                'name' => 'premium_expiry_date',
                'title' => '<i class="fa fa-calendar"></i>',
                'data-class' => 'expand',
                'class' => 'text-center',
                'width' => 10,
                
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
                'width' => '60'
            ]
        ];

        $html = $this->getDataTable(
            $builder,
            "User_TBL",
            $viewColumns,
            'Avatar',
            'admin-site-member-list',
            [[2, "desc"]],
            $this->multipleDelete
        );


        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['multipleDelete' => $this->multipleDelete])
            ->with(['FormURL' => route("admin-site-member-delete-multiple")])
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
        $this->pageData['SubNav'] = "Add WebUser";
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
            $action = route('admin-site-member-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-site-member-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm(
            'SiteUserFrm',
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
            $data = SiteUser::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');
            $updatedAppFiled = [
                //"attr" => ['readonly' => 'readonly'],
                //"tooltip" => "You can't change the Field."
            ];
        }

        $fmForm
            ->add(
                array(
                    "col" => 4,
                    "type" => "text",
                    "name" => "name",
                    "label" => "Name",
                    "value" => (isset($data->name) ? $data->name : ""),
                ), $updatedAppFiled
            )
            ->add(array(
                "col" => 4,
                "type" => "text",
                "name" => "email",
                "label" => "Email",
                "value" => (isset($data->email) ? $data->email : ""),
            ))
            ->add(array(
                "col" => (isset($data['avatar']) ? 3 : 4),
                "type" => "file",
                "name" => "avatar",
                "label" => "Avatar",
                "value" => (isset($data['avatar']) ? getUserAvatar($data['avatar']) : "")
            ))
            ->add(array(
                "col" => 4,
                "type" => "select",
                "options" => getYears(),
                "name" => "dob",
                "label" => "Date of Birth",
                "value" => (isset($data->dob) ? $data->dob : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 4,
                "type" => "select",
                "options" => getCountries(),
                "name" => "country",
                "label" => "Country",
                "value" => (isset($data->country) ? $data->country : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 4,
                "type" => "select",
                "options" => ['1' => 'Active', '0' => 'In-active'],
                "name" => "active",
                "label" => "Is Active",
                "value" => (isset($data->active) ? $data->active : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 4,
                "type" => "select",
                "options" => ['1' => 'Yes', '0' => 'No'],
                "name" => "is_author",
                "label" => "Is Author",
                "value" => (isset($data->is_author) ? $data->is_author : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 4,
                "type" => "select",
                "options" => ['1' => 'Yes', '0' => 'No'],
                "name" => "is_profile_complete",
                "label" => "Is Profile Complete",
                "value" => (isset($data->is_profile_complete) ? $data->is_profile_complete : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 4,
                "type" => "select",
                "options" => getGender(),
                "name" => "gender",
                "label" => "Gender",
                "value" => (isset($data->gender) ? $data->gender : ""),
                "attr" => ['style' => 'width:100%', 'class' => 'select2']
            ))
            ->add(array(
                "col" => 12,
                "type" => "text",
                "name" => "address",
                "label" => "Address",
                "value" => (isset($data->address) ? $data->address : ""),

            ))
            ->add(array(
                "col" => 12,
                "type" => "textarea",
                "name" => "profile",
                "label" => "Profile",
                "value" => (isset($data->profile) ? $data->profile : ""),

            ));

        return $fmForm->getForm();
    }

    public function sendEmailForm($id = "")
    {
        $data = array();
        $this->pageData['MainHeading'] = "Email";
        $this->pageData['PageTitle'] = "Send Email";
        $this->pageData['SubNav'] = "Send Email";
        $this->pageData['NavHeading'] = "Write & Send Email";

        $action = route('admin-site-member-send-email', $id);
        $method = 'patch';
        $fmForm = new FmForm(
            'SendEmailFrm',
            $action,
            $method,
            ['class' => 'smart-form', 'novalidate' => 'novalidate'],
            true
        );
        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->jsValidation($this->jsValidation);
        $fmForm->setter(['removeCancel' => true]);

        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {
            $data = SiteUser::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Send Email');
            $updatedAppFiled = [
                "attr" => ['readonly' => 'readonly'],
                "tooltip" => "You can't change the Field."
            ];
        }

        $fmForm
            ->add(
                array(
                    "col" => "12",
                    "type" => "html",
                    "html" => "Name : " . (isset($data->name) ? $data->name : ""),
                )
            )
            ->add(
                array(
                    "type" => "html",
                    "html" => "Email To: " . (isset($data->email) ? $data->email : ""),
                )
            )
            ->add(
                array(
                    "col" => 12,
                    "type" => "text",
                    "name" => "subject",
                    "label" => "Email Subject",
                    "value" => (isset($data->subject) ? $data->subject : ""),
                )
            )
            ->add(array(
                "col" => 12,
                "type" => "textarea",
                "name" => "emailContent",
                "label" => "Email Text",
                "value" => (isset($data->emailContent) ? $data->emailContent : ""),

            ));

        return $fmForm->getForm();
    }

    public function sendEmailAction(SendEmailRequest $request, $id = "")
    {
        $userRecord = SiteUser::find($id);
        \Notification::send($userRecord, new EmailToUserNotification($userRecord, $request));
        $request->session()->flash('alert-success', 'Email has been sent successfully to ' . $userRecord->email . '');
        return redirect()->route("admin-site-member-list");
    }

    /**
     * Display the specified resource
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
        $detailData = SiteUser::Select(
            'user_id as User ID',
            'email as Email',
            'name as Name',
            'dob as Date of Birth',
            'gender as Gender',
            'address as Address',
            'country as Country',
            'profile as Profile',
            // 'avatar as avatar',
            'active as Is Active',
            'is_profile_complete as Is Profile Complete',
            'is_author as Is Author',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['Created Date Time'] = my_date($detailData['Created Date Time'], 'jS F Y', '');
        $detailData['Updated Date Time'] = my_date($detailData['Updated Date Time'], 'jS F Y', '');

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
    public function update(SiteUserRequest $request, $id)
    {
        // Update Backend User
        try {
            $updateRecord = SiteUser::find($id);
            $updateRecord->name = $request->name;
            $updateRecord->email = $request->email;
            $updateRecord->is_author = $request->is_author;
            $updateRecord->is_profile_complete = $request->is_profile_complete;
            $updateRecord->country = $request->country;
            $updateRecord->gender = $request->gender;
            $updateRecord->profile = $request->profile;
            $updateRecord->address = $request->address;
            $updateRecord->active = $request->active;
            $updateRecord->dob = $request->dob;
            $updateRecord->updated_timestamp = time();

            // File upload here
            $fileName = '';
            $file = $request->file('avatar');
            if ($file) {
                // File upload here
                $destinationPath = storage_path("users");
                //Move Uploaded File
                $fileName = "avatar_" . time() . "." . $file->guessExtension();
                $file->move($destinationPath, $fileName);
                $updateRecord->avatar = $fileName;
            }

            if ($updateRecord->save()) {
                if (isset($request->name) && !empty($request->name)) {
                    $updateStory['author_name'] = $request->name;
                }

                if (isset($request->country) && !empty($request->country)) {
                    $updateStory['author_country'] = $request->country;
                }

                if (isset($request->gender) && !empty($request->gender)) {
                    $updateStory['author_gender'] = $request->gender;
                }

                if (isset($request->dob) && !empty($request->dob)) {
                    $updateStory['author_dob'] = $request->dob;
                }

                if (isset($request->address) && !empty($request->address)) {
                    $updateStory['author_address'] = $request->address;
                }

                Story::where('user_id', '=', $id)->update($updateStory);

                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->route("admin-site-member-list");
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
            $user = SiteUser::find($id);
            $user->is_blocked = 1;
            $user->email = '';
            $user->save();
            if ($user->delete()) {
                Comment::where("user_id", "=", $id)->delete();
                MonthAuthor::where("user_id", "=", $id)->delete();
                FavoriteAuthor::where('user_id','=',$id)->delete();
                FavoriteAuthor::where('author_id','=',$id)->delete();
                FavoriteStory::where('user_id','=',$id)->delete();

                $request->session()->flash('alert-success', $this->singularName . ' has been deleted successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Trash the specified user from the system.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function trashUser(Request $request, $id)
    {
        // Soft Delete Method
        try {
            $user = SiteUser::find($id);
            $user->is_blocked = 1;
            $user->save();
            if ($user->delete()) {
                $userStoriesIds = Story::select(['story_id'])->where("user_id", "=", "$id")->get()->toArray();
                if ($userStoriesIds) {
                    $userStoriesIds = array_column($userStoriesIds, "story_id");
                }
                Story::where("user_id", "=", $id)->delete();
                Comment::where("user_id", "=", $id)->delete();
                MonthAuthor::where("user_id", "=", $id)->delete();
                StoryStar::whereIn("story_id", $userStoriesIds)->delete();
                FavoriteAuthor::where('user_id','=',$id)->delete();
                FavoriteAuthor::where('author_id','=',$id)->delete();
                FavoriteStory::where('user_id','=',$id)->delete();
                $request->session()->flash('alert-success', $this->singularName . ' has been trashed successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
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
    public function destroyMany(Request $request)
    {
        // Soft Delete Method
        try {
            $id = $request->id;

            if (SiteUser::whereIn("user_id", $id)->delete()) {
                $userStoriesIds = Story::select(['story_id'])->whereIn("user_id", $id)->get()->toArray();

                if ($userStoriesIds) {
                    $userStoriesIds = array_column($userStoriesIds, "story_id");
                }

                Story::whereIn("user_id", $id)->delete();
                Comment::whereIn("user_id", $id)->delete();
                MonthAuthor::whereIn("user_id", $id)->delete();
                StoryStar::whereIn("story_id", $userStoriesIds)->delete();
                FavoriteAuthor::where('user_id','=',$id)->delete();

                $request->session()->flash('alert-success', $this->pluralName . ' has been deleted successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        $request->session()->flash('alert-success', $this->pluralName . ' has been deleted successfully!');
        return redirect()->back();
    }

    /**
     * Block and unblock user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateBlock(Request $request, $id)
    {
        // Soft Delete Method
        try {
            $updateRecord = SiteUser::find($id);
            $updateRecord->is_blocked = !$updateRecord->is_blocked;
            $updateRecord->updated_timestamp = time();
            if ($updateRecord->save()) {
                if ($updateRecord->is_blocked) {
                    if($updateRecord->last_login_ip != NULL){
                        BlockedIpAddress::create(['ip_address' => $updateRecord->last_login_ip]);
                    }
                    // \Notification::send($updateRecord, new BlockedUserNotification($updateRecord, $request));
                }
                else{
                    if($updateRecord->last_login_ip != NULL){
                        BlockedIpAddress::where('ip_address','LIKE',$updateRecord->last_login_ip)->delete();
                    }
                }
                $request->session()->flash('alert-success', $this->singularName . ' has been updated successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }
    public function premium(Request $request, $id){

        // Soft Delete Method
        try {
            $updateRecord = SiteUser::find($id);
            $updateRecord->is_premium = !$updateRecord->is_premium;
            
            if($updateRecord->premium_expiry_date == NULL){
                
                $updateRecord->premium_expiry_date = \Carbon\Carbon::today()->addYear()->subDay();
            }
            else{
                $updateRecord->premium_expiry_date = NULL;
            }
            
            $updateRecord->updated_timestamp = time();
            if ($updateRecord->save()) {
                if ($updateRecord->is_premium) {
                    $request->session()->flash('alert-success', $this->singularName . ' has been made premium user successfully!');
                }
                else{
                    $request->session()->flash('alert-success', $this->singularName . ' has been made regular user successfully!');
                }
                
            } else {
                $request->session()->flash('alert-danger', 'There is some issue. Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }
        return redirect()->back();
    }
    /**
     * Block and unblock user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request, $id)
    {
        $form = $this->sendEmailForm($id);
        return view('admin.add')
            ->with(['pageData' => $this->pageData])
            ->with(compact('form'))
            ->with(compact('jsValidator'));
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

        $apps = SiteUser::select($columns);
        $table = DataTables::of($apps);
        $table->addColumn('action', function ($apps) {
            $deleteURL = route('admin-site-member-delete', $apps->user_id);
            $blockUserURL = route('admin-site-member-block', $apps->user_id);
            $trashUserURL = route('admin-site-member-trash-user', $apps->user_id);
            $sendEmailURL = route('admin-site-member-send-email', $apps->user_id);
            $premiumUserURL = route('admin-site-member-premium', $apps->user_id);
            $blockTooltip = "";
            if ($apps->is_blocked == 1) {
                $blockTooltip = "Unblock User";
            } else {
                $blockTooltip = "Block User";
            }

            $authorOfMonth = "";
            if ($apps->is_author) {
                $authorOfMonth = '
                    <a href="' . route('admin-month-author-set', $apps->user_id) . '" 
                    class="btn btn-xs btn-default txt-color-white" rel="tooltip" data-placement="top" 
                    data-original-title="Set Author of Month" style="background: INDIGO;">
                        <i class="glyphicon glyphicon-star" style="color: #47588F;"></i>
                    </a>
                ';
            }

            return '<a href="' . route('admin-site-member-edit', $apps->user_id) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="' . route('admin-site-member-detail', $apps->user_id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="glyphicon glyphicon-th-list"></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn bg-color-orange txt-color-white" onclick="confirmBoxOnBlock(\'' . $blockUserURL . '\')" rel="tooltip" data-placement="top" data-original-title="' . $blockTooltip . '"><i class="fa fa-info-circle" ></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $trashUserURL . '\')" rel="tooltip" data-placement="top" data-original-title="Trash User"><i class="glyphicon glyphicon-trash" ></i> </a>
                    <a href="' . $sendEmailURL . '"  class="btn btn-xs btn bg-color-green  txt-color-white"  rel="tooltip" data-placement="top" data-original-title="Email/Warn User "><i class="fa fa-envelope-o " ></i> </a>
                    <a href="' . $premiumUserURL . '"  class="btn btn btn-xs btn-info"  rel="tooltip" data-placement="top" data-original-title="Premium"><i class="fa fa-credit-card" ></i> </a>'. $authorOfMonth;
        });
        $table->editColumn('avatar', function ($user) {
            return getUserAvatar($user->avatar, ucwords($user->name));
        });
        $table->editColumn('name', function ($user) {
            return ucwords($user->name);
        });
        $table->editColumn('active', function ($user) {
            return isset($user->active) && !empty($user->active) ? "Yes" : "No";
        });
        
        $table->editColumn('is_premium', function ($user) {
            return isset($user->is_premium) && !empty($user->is_premium) ? "Yes" : "No";
        });
        $table->editColumn('premium_expiry_date', function ($user){
            return isset($user->premium_expiry_date) && !empty($user->premium_expiry_date) ? $user->premium_expiry_date->format('m/d/Y') : 'N/A';  
        });
        $table->editColumn('is_author', function ($user) {
            if ($user->is_author == 1) {
                return 'Yes';
            } else {
                if ($user->is_author == 0 || $user->is_author == '') {
                    return 'No';
                }
            }
            //  return isset($user->is_author) && !empty($user->is_author) ? "Yes" : "No";
        });
        $table->filterColumn('is_author', function ($query, $keyword) {
            $keyword = isset($keyword) && !empty($keyword) ? 1 : 0;
            if ($keyword == 1) {
                $query->where("is_author", 1);
            } else {
                $query->where("is_author", 0)->orWhereNull('is_author');
            }
        });
        $table->editColumn('story_count', function ($user) {
            return isset($user->story_count) && !empty($user->story_count) ? $user->story_count : 0;
        });
        $table->editColumn('is_profile_complete', function ($user) {
            return isset($user->is_profile_complete) && !empty($user->is_profile_complete) ? "Yes" : "No";
        });
        $table->editColumn('is_blocked', function ($user) {
            return isset($user->is_blocked) && !empty($user->is_blocked) ? "Yes" : "No";
        });
        $table->editColumn('created_timestamp', function ($apps) {
            return my_date($apps->created_timestamp);
        });
        $table->filterColumn('created_timestamp', function ($query, $keyword) {
            $query->whereRaw(
                "DATE_FORMAT(FROM_UNIXTIME(created_timestamp), '%d-%m-%Y %h:%i:%s') like ? ",
                [" % $keyword % "]
            );
        });
        $table->editColumn('updated_timestamp', function ($apps) {
            return my_date($apps->updated_timestamp);
        });
        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
            $query->whereRaw(
                "DATE_FORMAT(FROM_UNIXTIME(updated_timestamp), '%d-%m-%Y %h:%i:%s') like ? ",
                [" % $keyword % "]
            );
        });
        $table->filterColumn('name', function ($query, $keyword) {
            $query->whereRaw("users.name like ?", ["$keyword%"]);
        });
        $table->filterColumn('story_count', function ($query, $keyword) {
            if ($keyword = 0) {
                $query->whereRaw("users.story_count = $keyword")->orWhereNull('users.story_count');
            };
        });
        $table->rawColumns(['avatar', 'action']);

        /*If custom Filter Added.
        if ($this->advanceFilters) {
            $customFilters = $request->get('filter');
            $customFilters = \GuzzleHttp\json_decode($customFilters);
            foreach ($customFilters as $k => $cF) {
                if ($cF->filter == 'is_profile_complete' || $cF->filter == 'active' || $cF->filter == 'is_author' || $cF->filter == 'is_blocked') {
                    $cF->value = (strtolower($cF->value) == "yes") ? 1 : 0;
                }
                $customFilters->$k = $cF;
            }
            // Update Value for Yes No Filter
            $customFilters = \GuzzleHttp\json_encode($customFilters);
            $request->updatedFilter = $customFilters;
            setAdvanceFilter($request, $table);
        }*/

        return $table->make(true);
    }
}
