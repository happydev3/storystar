<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Routing\Route;

class StoryRequest extends FormRequest
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

    public function messages()
    {
        return [
            'author_name.required_if' => 'The author name field is required.',
            'author_address.required_if' => 'The author address field is required.',
            'author_country.required_if' => 'The author country field is required.',
            'author_gender.required_if' => 'The author gender field is required.',
            'author_dob.required_if' => 'The author DOB field is required.',
            'user_id.required_without' => 'Please select an author.',
        ];
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
                    //'story_title' => 'required|string|max:40',
                    'story_title' => 'required|string',
                    //'short_description' => 'required|string|max:250',
                    'short_description' => 'required|string',
                    'theme_id' => 'required',
                    'subject_id' => 'required',
                    'category_id' => 'required',
                    'sub_category_id' => 'required',
                    'the_story' => 'required|string',
                    'status' => 'required',
                    // 'written_by' => 'required',
                    //  'user_id' => 'required',
                    //'user_id' => 'required_if:self_story,!=,Yes',
                    'user_id' => 'required_without:self_story',
                    'author_name' => 'required_if:self_story,==,Yes',
                    'author_address' => 'required_if:self_story,==,Yes',
                    'author_country' => 'required_if:self_story,==,Yes',
                    'author_gender' => 'required_if:self_story,==,Yes',
                    // 'author_dob' => 'required_if:self_story,==,Yes',

                ];
            }
                break;
            case 'POST': {

                $rules = [
                    //'story_title' => 'required|string|max:40',
                    'story_title' => 'required|string',
                    //'short_description' => 'required|string|max:250',
                    'short_description' => 'required|string',
                    'theme_id' => 'required',
                    'subject_id' => 'required',
                    'category_id' => 'required',
                    'sub_category_id' => 'required',
                    'the_story' => 'required|string',
                    'status' => 'required',
                    //  'user_id' => 'required',
                    // 'written_by' => 'required',
                    'user_id' => 'required_without:self_story',
                    'author_name' => 'required_if:self_story,==,Yes',
                    'author_address' => 'required_if:self_story,==,Yes',
                    'author_country' => 'required_if:self_story,==,Yes',
                    'author_gender' => 'required_if:self_story,==,Yes',
                    // 'author_dob' => 'required_if:self_story,==,Yes',

                ];


            }
                break;
            case 'PUT':
                break;
            case 'PATCH': {
                $rules = [
                    //'story_title' => 'required|string|max:40',
                    'story_title' => 'required|string',
                    //'short_description' => 'required|string|max:250',
                    'short_description' => 'required|string',
                    'theme_id' => 'required',
                    'subject_id' => 'required',
                    'category_id' => 'required',
                    'sub_category_id' => 'required',
                    'the_story' => 'required|string',
                    'status' => 'required',
                    // 'user_id' => 'required',
                    // 'written_by' => 'required',
                    'user_id' => 'required_without:self_story',
                    'author_name' => 'required_if:self_story,==,Yes',
                    'author_address' => 'required_if:self_story,==,Yes',
                    'author_country' => 'required_if:self_story,==,Yes',
                    'author_gender' => 'required_if:self_story,==,Yes',
                    //  'author_dob' => 'required_if:self_story,==,Yes',
                ];
            }
                break;
            default:
                break;
        }


        return $rules;
    }
}
