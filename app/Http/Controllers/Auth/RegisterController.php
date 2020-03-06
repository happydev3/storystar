<?php

namespace App\Http\Controllers\Auth;

use App\Models\SiteUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use JsValidator;
use App\Notifications\ConfirmEmailNotification;
use Illuminate\Notifications\Notifiable;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use Notifiable;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $jsValidation = true;

    public $PageData = [];

    protected $validationRules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
        //'password' => 'required|string|min:6|confirmed',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, $this->validationRules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = SiteUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'created_timestamp' => time(),
            'updated_timestamp' => time(),
            'verify_token' => Str::random(40)
        ]);

        $user->notify(new ConfirmEmailNotification($user));
        return $user;

    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {

        $this->pageData['PageTitle'] = config('app.name') . ".com - Sign up";

        // Js form validation
        $validator = JsValidator::validator(
            $this->validator([]), '#registerForm'
        );
        return view('app.register')
            ->with(['pageData' => $this->pageData])
            ->with(['validator' => $validator])
            ->with(['jsValidation' => $this->jsValidation]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $request->session()->flash('alert-success', trans('auth.emailverifysuccess'));

        return redirect(route('app-verify-email-first'));


    }


    public function verifyEmail()
    {
        $this->pageData['PageTitle'] = "Verification Email Sent";

        return view('app.verification-sent')
            ->with(['pageData' => $this->pageData]);

    }

    public function verifyEmailToken(Request $request, $confirmation_code)
    {

        $user = SiteUser::where("verify_token", "=", $confirmation_code)->first();

        if (!$user) {
            $request->session()->flash('alert-danger', trans('auth.emailverifytokenerror'));
            return redirect(route('login'));
        }

        $user->active = 1;
        $user->verify_token = null;
        $user->save();
        $request->session()->flash('alert-success', trans('auth.emailverifytokensuccess'));

        return redirect(route('login'));


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

}
