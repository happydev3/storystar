<?php

namespace App\Http\Controllers;

use App\Models\ContestEntries;
use App\Models\PointsHistory;
use App\Models\SiteUser;
use App\Models\Story;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JsValidator;
use App\Models\Apps;
use App\Models\Subscribe;
use Illuminate\Support\Str;
use JWTAuth;
use Illuminate\Support\Facades\Input;
use App\Notifications\ConfirmEmailNotification;
use App\Notifications\PremiumMembershipNotification;
use Auth;

class UserController extends Controller
{
    public $pageData = [];
    public $perPage = 15;
    protected $jsValidation = true;
    protected $settingUpdateRules = [];
    protected $settingUpdateMessages = [];
    protected $passwordUpdateRules = [
        'current-password' => 'required',
        'password' => 'required|same:password|min:6',
        'password_confirmation' => 'required|same:password',

    ];
    protected $passwordUpdateMessages = [
        'current-password.required' => 'Please enter current password',
        'password.required' => 'Please enter password',
        'password.min' => 'Please enter minimum 6 characters.',
    ];

    public function __construct(Request $request)
    {
        $this->middleware('auth')->except(['profile', 'addSubscriber', 'unSubscribe']);
        $this->pageData['s'] = isset($request->s) ? $request->s : '';
        $this->pageData['theme'] = isset($request->theme) ? $request->theme : '';
        $this->pageData['subject'] = isset($request->subject) ? $request->subject : '';
        $this->pageData['category'] = isset($request->category) ? $request->category : '';
        $this->pageData['subcategory'] = isset($request->subcategory) ? $request->subcategory : '';
        $this->pageData['sortby'] = isset($request->sortby) ? $request->sortby : 'desc';
        $this->pageData['user_id'] = isset($request->user_id) ? $request->user_id : '';
        $this->pageData['page'] = isset($request->page) ? $request->page : '';
        $this->pageData['limit'] = isset($request->limit) ? $request->limit : '';
        $this->pageData['queryString'] = Input::only([
            's',
            'theme',
            'subject',
            'subcategory',
            'sortby',
            'limit'
        ]); // sensible examples

        if (isset($request->limit) && !empty($request->limit)) {
            $this->perPage = $request->limit;
        }
    }

    public function index()
    {
    }

    public function profile(Request $request)
    {
        if ($request->user_id) {
            $author = [];
            $author = SiteUser::with("favoriteauthors")->find($request->user_id);

            /* If user is deleted from admin.*/
            if (!$author) {
                return abort(404);
            }

            $favAdded = 0;
            if (\Auth::user() && $author->user_id != \Auth::user()->user_id) {
                if (!$author->favoriteauthors) {
                    $favAdded = 0;
                } else {
                    $favAdded = $author->favoriteauthors->where(
                        "user_id",
                        "=",
                        \Auth::user()->user_id
                    )->where("author_id", "=", $author->user_id)->count();
                }

                // $favAdded = isset($favAdded) ? $favAdded : 0;
            }

            $this->pageData['PageTitle'] = config('app.name') . ".com - " . $author->name . "'s Profile";
            $this->pageData['perPage'] = $this->perPage;

            $story = new Story();
            $paginator = $story->getStories($this->pageData);
            return view('app.profile')
                ->with(['pageData' => $this->pageData])
                ->with(['author' => $author])
                ->with(compact('favAdded'))
                ->with(compact('paginator'));
        }
    }

    public function accountValidation()
    {
        $userID = \Auth::User()->user_id;
        $this->settingUpdateRules = [
            // 'name' => 'required|string|max:50',
            'email' => "required|email|unique:users,email,$userID,user_id,deleted_at,NULL",
            'gender' => 'required_if:is_author,==,1',
            // 'profile' => 'required_if:becomeAuthor,==,1',
            'dob' => 'nullable|numeric|between:1900,'.Carbon::now()->year,
            // 'address' => 'required_if:becomeAuthor,==,1',
            //  'country' => 'required_if:becomeAuthor,==,1',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:5000',
        ];
        $this->settingUpdateMessages = [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'gender.required_if' => 'Please select your gender',
            //  'profile.required_if' => 'Please enter something about yourself.',
            'dob.required' => 'Please select your birth year',
            'address.required_if' => 'Please enter your city/state',
            'country.required_if' => 'Please select your country',
            'avatar.mimes' => 'Your photo couldn\'t be uploaded. Photos should be of less than 5 Mb and saved as JPG, JPEG or PNG files',
            'avatar.max' => 'Your photos couldn\'t be uploaded. Photos should be smaller than 5 MB.',
        ];
    }

    public function account(Request $request)
    {
        // Calling Validation Rules
        $this->accountValidation();
        $pageName = \Request::route()->getName();

        // Js form validation
        if ($pageName == "app-account") {
            $this->pageData['PageTitle'] = config('app.name') . ".com - My Profile";
            $validator = JsValidator::make($this->settingUpdateRules, $this->settingUpdateMessages);
        } elseif ($pageName == "app-points-detail") {
            $this->pageData['PageTitle'] = config('app.name') . ".com - Points Detail";
            $stories = Story::userStoriesDropDown(\Auth::user()->user_id);
            $authors = SiteUser::activeUsersDropdown(true);
            reset($authors);
            $firstAuthor = key($authors);
            $stories = Story::userStoriesDropDown(\Auth::user()->is_author == 1 ? \Auth::user()->user_id : $firstAuthor);
            $history = PointsHistory::userHistory(\Auth::user()->user_id);
        } elseif ($pageName == "app-points-history") {
            $this->pageData['PageTitle'] = config('app.name') . ".com - Points Detail";
            $history = PointsHistory::userHistory(\Auth::user()->user_id);
        } elseif ($pageName == "app-update-password-form") {
            $this->pageData['PageTitle'] = config('app.name') . ".com - Update Password";
            $validator = JsValidator::make($this->passwordUpdateRules, $this->passwordUpdateMessages);
        } elseif ($pageName == "app-points-usage") {
            $this->pageData['PageTitle'] = config('app.name') . ".com - Points Usage";
        } elseif ($pageName == "app-profile-setup") {
            $this->pageData['PageTitle'] = config('app.name') . ".com - Profile Setup";
        }

        return view('app.account')
            ->with(compact('validator', 'stories', 'history', 'authors'))
            ->with(['pageData' => $this->pageData])
            ->with(['jsValidation' => $this->jsValidation]);
    }

    public function authorStories(Request $request, $id)
    {
        $stories = Story::userStoriesDropDown($id);
        return response()->json($stories);
    }

    public function history(Request $request)
    {
        $history = PointsHistory::userHistoryType($request->type, \Auth::user()->user_id);
        return response()->json($history);
    }

    public function updatePassword(Request $request)
    {
        if (\Auth::Check()) {
            $request_data = $request->All();
            $validator = Validator::make($request_data, $this->passwordUpdateRules, $this->passwordUpdateMessages);
            if ($validator->fails()) {
                $request->session()->flash(
                    'alert-danger',
                    'There is some issue in updating your password. Please go through again.'
                );
                return redirect()->back()->withInput()->withErrors($validator->errors());
            } else {
                $current_password = \Auth::User()->password;
                if (\Hash::check($request_data['current-password'], $current_password)) {
                    $user_id = \Auth::User()->user_id;
                    $obj_user = SiteUser::find($user_id);
                    $obj_user->password = bcrypt($request_data['password']);

                    if ($obj_user->save()) {
                        $request->session()->flash('alert-success', 'Your password has been updated successfully.');
                        return redirect()->back();
                    } else {
                        $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
                        return redirect()->back()->withInput()->withErrors($validator->errors());
                    }
                } else {
                    $request->session()->flash('alert-danger', 'Please enter correct current password.');
                    return redirect()->back()->withInput()->withErrors($validator->errors());
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function giftPoints(Request $request)
    {
        $user = SiteUser::where(['user_id' => $request->to_user])->first();
        if (!$user) {
            $request->session()->flash(
                'alert-danger',
                'No user found with this id.'
            );
            return redirect()->back()->withInput();
        } elseif (!is_numeric($request->points)) {
            $request->session()->flash(
                'alert-danger',
                'Please enter valid points'
            );
            return redirect()->back()->withInput();
        } elseif (\Auth::user()->points < $request->points) {
            $request->session()->flash(
                'alert-danger',
                'You do not have sufficient points to gift.'
            );
            return redirect()->back()->withInput();
        } else {
            PointsHistory::gift($request);
            $request->session()->flash('alert-success', 'Points gifted successfully.');
            return redirect()->back()->withInput();
        }
    }

    public function enterContest(Request $request)
    {
        
        if (\Auth::user()->points < 500) {
            $request->session()->flash(
                'alert-danger',
                'You need to have at least 500 points to enter into contest.'
            );
            return redirect()->back()->withInput();
        } else {
            ContestEntries::enter($request);
            $request->session()->flash('alert-success', 'Contest entry successfully made.');
            
            
            
            
            return redirect()->back()->withInput();
        }
    }
    
    public function premiumWithPoint(Request $request) 
    {
        
        $auth_user = \Auth::user();
        if($auth_user->points < 1200) {
            $request->session()->flash(
                'alert-danger',
                'Sorry, but you have not yet earned enough points to pay for your Premium Membership upgrade. Please earn the points you need through Storystar participation, and then try again. Thank you.'
            );
            return redirect()->back()->withInput();
        } else {
            $auth_user->is_premium = 1;
            $auth_user->points = $auth_user->points - 1200;
            $auth_user->premium_expiry_date = \Carbon\Carbon::today()->addYear()->subDay();
            $auth_user->update();
            
            
            
            $deducatedPoints = new PointsHistory();
            $deducatedPoints->user_id = $auth_user->user_id;
            $deducatedPoints->given_user_id = $auth_user->user_id;
            $deducatedPoints->points_category_id = '17';
            $deducatedPoints->action_type = 'premium_upgrade_points';
            $deducatedPoints->points = -1200;
            $deducatedPoints->created_at = \Carbon\Carbon::now();
            $deducatedPoints->save();
            
            $notificationData = [
                'email' => \Auth::user()->email
            ];
            Admin::all();
            \Notification::send(Admin::all(), new PremiumMembershipNotification($notificationData));
            
            
            $request->session()->flash('alert-success', 'Premium membership is upgraded successfully. 1200 points were deducated in your points.');
            return redirect()->back()->withInput();
        }
        
    }

    public function updateSettings(Request $request)
    {
        $updateEmailAction = false;
        // Calling Validation Rules
        $this->accountValidation();

        if (\Auth::Check()) {
            $request_data = $request->All();
            $validator = Validator::make($request_data, $this->settingUpdateRules, $this->settingUpdateMessages);
            if ($validator->fails()) {
                $request->session()->flash(
                    'alert-danger',
                    'There is some issue in updating your settings. Please go through again.'
                );
                return redirect()->back()->withInput()->withErrors($validator->errors());
            } else {
                $user_id = \Auth::User()->user_id;
                $user_email = \Auth::User()->email;

                /*echo $length = strlen(utf8_decode($request->profile));
                exit;
                if ($request->profile) {
                    $request->profile = substr($request->profile, 0, 10000);
                }*/

                $obj_user = SiteUser::find($user_id);
                //  $obj_user->name = $request->name;
                $obj_user->gender = $request->gender;
                if (!empty($request->dob)) {
                    $obj_user->dob = $request->dob;
                }

                if (!empty($request->country)) {
                    $obj_user->country = $request->country;
                }

                if (!empty($request->address)) {
                    $obj_user->address = $request->address;
                }

                $obj_user->profile = $request->profile;

                if ($user_email != $request->email) {
                    $updateEmailAction = true;
                    $obj_user->email = $request->email;
                    $obj_user->verify_token = Str::random(40);
                    $obj_user->active = 0;
                }

                $file = $request->file('avatar');
                // File upload here
                $fileName = isset($obj_user->avatar) ? $obj_user->avatar : '';
                if ($file) {
                    //Move Uploaded File
                    $fileName = NewGuid() . "_" . time() . "." . $file->guessExtension();
                    $destinationPath = 'storage/users/';
                    $file->move($destinationPath, $fileName);
                    $obj_user->avatar = $fileName;
                }

                // is_author
                if (isset($request->becomeAuthor) && !empty($request->becomeAuthor)) {
                    $obj_user->is_author = 1;
                }

                // is_profile_complete
                if (!empty($request->profile) || !empty($fileName)) {
                    $obj_user->is_profile_complete = 1;
                }

                if ($obj_user->save()) {
                    // Send Email on update email field.
                    if (isset($updateEmailAction) && $updateEmailAction == true) {
                        $user = SiteUser::where("email", "=", $request->email)->first();
                        \Notification::send($user, new ConfirmEmailNotification($user));
                    }

                    $request->session()->flash('alert-success', 'Your account settings are updated successfully.');
                    return redirect()->back();
                } else {
                    $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
                    return redirect()->back()->withInput()->withErrors($validator->errors());
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function resendVerifyEmail(Request $request)
    {
        if (isset($request->email) && !empty($request->email)) {
            $user = SiteUser::where("email", "=", $request->email)->first();
            \Notification::send($user, new ConfirmEmailNotification($user));
            $request->session()->flash('alert-success', trans('auth.emailverifysuccessresend'));
            return redirect()->back();
        }
    }

    public function addSubscriber(Request $request)
    {
        if (request()->ajax()) {
            $validationRules = [
                'name' => 'required',
                'email' => 'required|email|unique:subscriber_list,email',

            ];
            $validationMessages = [
                'email.required' => 'Please enter your email.',
                'email.email' => 'Please enter a valid email.',
                'email.unique' => 'You have already subscribed to our newsletter',
                'name.required' => 'Please enter your name.'
            ];

            $validation = Validator::make($request->all(), $validationRules, $validationMessages);
            if ($validation->fails()) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_error',
                    'message' => $validation->errors()
                ]);
            }

            try {
                $Record = [];
                $Record['updated_timestamp'] = time();
                $Record['created_timestamp'] = time();
                $Record['email'] = $request->email;
                $Record['name'] = $request->name;

                if (Subscribe::create($Record)) {
                    return response()->json([
                        'code' => 200,
                        'success' => 'subscribe_successfully',
                        'message' => 'Thank you for the subscription. You will receive exclusive stories by some of our best authors.'
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json(['code' => 201, 'error' => '', 'message' => $e->getMessage()]);
            }
        }
    }


    public function unsubscribeBulk(){
      $user = Auth::User();
      $user->unsubscribed = 1;
      $user->update();
      return redirect()->route('unsubscribed');
    }


    public function unSubscribe(Request $request)
    {
        if (isset($request->email) && !empty($request->email)) {
            $Record = [];
            $request->email = base64_decode($request->email);
            $Record = Subscribe::where("email", "=", "$request->email")->get()->count();

            if ($Record == 0) {
                return abort(404);
            }

            Subscribe::where("email", "=", "$request->email")->delete();
            return view('app.unsubscribe')
                ->with(['pageData' => $this->pageData])
                ->with(['request' => $request]);
        } else {
            return abort(404);
        }
    }
}
