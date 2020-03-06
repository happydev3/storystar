<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Password;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;
use JsValidator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $jsValidation = true;

    public $request = "";

    protected $validationRules = [
        'email' => 'required|string|email|max:255',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|same:password',
    ];

    protected $validationMessages = [
        'password_confirmation.required' => 'Please confirm your password',
    ];


//'password-confirm' => 'required|same:password',
//'password' => 'required|confirmed|min:6',

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        $this->request = $request;
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
        return Validator::make($data, $this->validationRules, $this->validationMessages);
    }


    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     * Override by Faisal
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        // Js form validation
        $validator = JsValidator::validator(
            $this->validator([]), '#resetPasswordForm'
        );


        $this->pageData['PageTitle'] = config('app.name') . ".com - Reset Password";

        return view('app.passwords.reset')
            ->with(['pageData' => $this->pageData])
            ->with(['token' => $token, 'email' => $request->email])
            ->with(['validator' => $validator])
            ->with(['jsValidation' => $this->jsValidation]);
    }


    public function redirectPath()
    {

        $this->request->session()->flash('alert-success', 'Your password has been changed successfully!');

        return route('login');
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {


        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

    }


}
