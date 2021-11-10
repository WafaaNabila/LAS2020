<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminEditRequest extends FormRequest
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
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255',
            'phoneNum'      => 'required|string',
        ];
    }

        public function messages()
    {
        return [
            'name.required'         => 'Please enter employee name!',
            'name.max'              => 'You have reached the max characters for name! (255 characters)',
            'email.required'        => 'Please enter email address!',
            'email.max'             => 'You have reached the max characters for email! (255 characters)',
            'email.unique'          => 'The email entered has already exist! Please re-enter new email.',
            'phoneNum.required'     => 'Please enter phone number!',
            'phoneNum.size'          => 'You have reached the max characters for phone number!',
        ];

    }
}
