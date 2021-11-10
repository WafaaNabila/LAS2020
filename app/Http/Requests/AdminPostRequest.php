<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPostRequest extends FormRequest
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
            'email'         => 'required|string|email|max:255|unique:users',
            'ic'            => 'required|string|unique:employee_details',
            'phoneNum'      => 'required|string',
            'date_joined'   => 'required|date_format:d/m/Y',
            'gender_id'     => 'required|integer',
            'role_id'       => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Please enter employee name!',
            'name.max'              => 'You have reached the max characters for name! (255 characters)',
            'email.required'        => 'Please enter email address!',
            'email.max'             => 'You have reached the max characters for email! (255 characters)',
            'email.unique'          => 'The email entered has already exist! Please re-enter a new email.',
            'ic.required'           => 'Please enter IC number!',
            'ic.unique'             => 'The IC number entered has already exist! Please re-enter a new IC number.',
            'phoneNum.required'     => 'Please enter phone number!',
            'date_joined.required'  => 'Please enter date joined!',
            'date_joined.date_format'=> 'Date joined must be in dd/mm/yyyy format!',
            'gender_id.required'    => 'Please enter gender!',
            'role_id.required'      => 'Please enter role!',
        ];

    }
}
