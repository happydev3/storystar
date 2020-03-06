<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Routing\Route;

class SubCategoryRequest extends FormRequest
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
                    'sub_category_title' => 'required',
                    'sub_category_title2' => 'required',
                    'sub_category_title3' => 'required',
                ];
            }
                break;
            case 'POST': {

                $rules = [
                    'sub_category_title' => 'required',
                    'sub_category_title2' => 'required',
                    'sub_category_title3' => 'required',

                ];


            }
                break;
            case 'PUT':
                break;
            case 'PATCH': {
                $rules = [
                    'sub_category_title' => 'required',
                    'sub_category_title2' => 'required',
                    'sub_category_title3' => 'required',
                ];
            }
                break;
            default:
                break;
        }


        return $rules;
    }
}
