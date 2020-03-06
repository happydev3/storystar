<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Routing\Route;

class MonthAuthorRequest extends FormRequest
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
                    'user_id' => 'required',
                    //'month' =>'required|unique:month_author,deleted_at,NULL',
                    'month' => 'required|unique:month_author,month,NULL,id,deleted_at,NULL',

                ];
            }
                break;
            case 'POST': {

                $rules = [
                    'user_id' => 'required',
                    'month' => 'required|unique:month_author,month,NULL,id,deleted_at,NULL',
                ];

            }
                break;
            case 'PUT':
                break;
            case 'PATCH': {
                $rules = [
                    'user_id' => 'required',
                    'month' => "required|unique:month_author,month,$id,id,deleted_at,NULL",
                ];
            }
                break;
            default:
                break;
        }


        return $rules;
    }
}
