<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PointsHistoryRequest extends FormRequest
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
            case 'GET':
                $rules = [];
                break;
            case 'POST':
                $rules = [];
                break;
            case 'PUT':
                break;
            case 'PATCH':
                $rules = [];
                break;
            default:
                break;
        }

        return $rules;
    }
}
