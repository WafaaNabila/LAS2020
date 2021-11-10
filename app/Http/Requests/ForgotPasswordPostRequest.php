<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordPostRequest extends FormRequest
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
            'email' => 'required|email|exists:users'
        ];
    }

    public function messages()
    {
        return [

            'email.required'    => 'Please enter your email!',
            'email.email'       => 'Please make sure input is an email address.',
            'email.exists'      => 'This email does not exists!'
        ];


    }
}
