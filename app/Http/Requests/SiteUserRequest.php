<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Routing\Route;

class SiteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = \Request::segment(4);

        switch ($this->method()) {
            case 'GET': {
                $rules = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'avatar' => 'image',
                ];
            }
                break;
            case 'POST': {

                $rules = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'avatar' => 'image',

                ];

            }
                break;
            case 'PUT':
                break;
            case 'PATCH': {
                $rules = [
                    'name' => 'required',
                    'email' => "required|email|unique:users,email,$id,user_id,deleted_at,NULL",
                    'avatar' => 'image',

                ];
            }
                break;
            default:
                break;
        }


        return $rules;
    }
}
