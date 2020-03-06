<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JsValidator;
use Illuminate\Support\Facades\Validator;
use App\Models\SiteUser;
use Image;

class UploadController extends Controller
{
    public $pageData = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //'contact', 'contactAction'
        $this->middleware('auth')->except([]);
    }

    /**
     * Show the application ajaxImageUploadPost.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadProfilePhoto(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($validator->passes()) {


            $user_id = \Auth::User()->user_id;
            $obj_user = SiteUser::find($user_id);

            $file = $request->file('image');

            // File upload here
            $fileName = isset($obj_user->avatar) ? $obj_user->avatar : '';
            if ($file) {
                //Move Uploaded File
                $fileName = NewGuid() . "_" . time() . "." . $file->guessExtension();
                $destinationPath = 'storage/users/';
                $file->move($destinationPath, $fileName);
                $obj_user->avatar = $fileName;
            }

            $url = Image::url(storage_url($obj_user->avatar, 'users'), 212, 212, array('crop'));

            if ($obj_user->save()) {
                return response()->json(['success' => 'done', 'newthumb' => $url]);
            }
        }


        return response()->json(['error' => $validator->errors()->all()]);
    }


}