<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Password;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest:admin');
    }

    /**
     * Show the application's login form.
     * Override the method by Faisal Mehmood 8-12-2017
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {

        $this->pageData['PageTitle'] = "Forgot Password";
        return view('admin.passwords.email')->with(['pageData' => $this->pageData]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $response = '';

        // $this->validate($request, ['username' => 'required'], ['username.required' => 'Please enter your username.']);

        if (isset($request->email) && !empty($request->email)):
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
        endif;

        if (isset($request->username) && !empty($request->username)):
            $response = $this->broker()->sendResetLink(
                $request->only('username')
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
