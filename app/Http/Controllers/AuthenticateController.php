<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;
use Event;
use App\Events\AuthenticationDone;

class AuthenticateController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function authenticate(Request $request)
    {


        $validation = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {

            return response()->json(['error' => 'missing_fields', 'messages' => $validation->messages()->toArray()], 401);

        } else {

            if (is_numeric($request->input('login'))) {
                $login_type = 'phone_number';
            } else {
                $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
                    ? 'email'
                    : 'username';
            }


            $request->merge([
                $login_type => $request->input('login')
            ]);

            $credentials = $request->only($login_type, 'password');



            try {

                // verify the credentials and create a token for the user

                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 201);
                }

            } catch (JWTException $e) {

                // something went wrong
                return response()->json(['error' => 'could_not_create_token'], 500);
            }



            $userModel = User::where($login_type, $request->input($login_type))->get()->first();

            $token = '';
            $userStatus = $userModel->user_status;

            if ($userModel->user_status == 'Active') {
                $customClaims = [
                    'role_id' => $userModel->role_id,
                    'user_name' => $userModel->username,
                    'user_status' => $userModel->user_status
                    //'email' => $userModel->email,
                ];

                $payload = app('tymon.jwt.payload.factory')->make($customClaims);

                $token = JWTAuth::encode($payload)->get();

              //  Event::fire(new AuthenticationDone($userModel, 'Login'));



            }

            $code = 200;
            $success = 'authenticated_successfully.';

            // if no errors are encountered we can return a JWT
            return response()->json(compact('code', 'token', 'success', 'userStatus'));

        }

    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        if ($token) {
            JWTAuth::setToken($token)->invalidate();
            return response()->json(['code' => 200, 'success' => 'logout_successfully', 'message' => 'You have logout'], 200);

        } else {
            return responce()->json(['code' => 202, 'error' => 'logout_fail', 'message' => 'You have\'t logout'], 202);
        }

    }

}