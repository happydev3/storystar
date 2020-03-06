<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Password;
use Illuminate\Support\Facades\Validator;
use JsValidator;


class ForgotPasswordController extends Controller
{
    public $PageData = [];
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $jsValidation = true;

    protected $validationRules = [
        'email' => 'required|string|email|max:255',
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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {

        // Js form validation
        $validator = JsValidator::validator(
            $this->validator([]), '#requestForm'
        );


        $this->pageData['PageTitle'] = config('app.name') . ".com - Reset Password";

        return view('app.passwords.email')
            ->with(['pageData' => $this->pageData])
            ->with(['validator' => $validator])
            ->with(['jsValidation' => $this->jsValidation]);
    }


    public function sendResetLinkEmail(Request $request)
    {

        $response = '';

        if (isset($request->email) && !empty($request->email)):
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
        endif;


        if ($response == "") {
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
        }

        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        }

        return back()->withErrors(
            ['email' => trans($response)]
        );
    }


}
