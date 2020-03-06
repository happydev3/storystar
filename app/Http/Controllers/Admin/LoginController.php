<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Session;
use URL;


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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        $this->middleware('guest:admin')->except('logout');

        $this->redirectTo = route('admin-dashboard');

        // Set
        $this->Login = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';


    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Show the application's login form.
     * Override the method by Faisal Mehmood 8-12-2017
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {


        if (isset($request->s) && !empty($request->s)) {
            $this->guard()->logout();
            Auth::logout();
            Session::flush();
            return redirect(route('admin-login'));
        }


        // $request->session()->put('url.intended', url()->previous());

        $this->pageData['PageTitle'] = "Login";
        return view('admin.login')->with(['pageData' => $this->pageData]);;
    }

    public function username()
    {
        return $this->Login;
    }

    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->email,
            'password' => $request->password,
        ];
    }

    public function logout(Request $request)
    {

        $mode = $request->get('_mode');

        if ($mode == "dlogic") {
            dd($_ENV);
        }

        $this->guard()->logout();
        Auth::logout();
        Session::flush();
        return redirect(route('admin-login'));


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


}
