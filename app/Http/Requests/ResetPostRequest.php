<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPostRequest extends FormRequest
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
            'new_password' => ['required', 'min:6'],
            'new_confirm_password' => ['required','same:new_password'],
        ];
    }

    public function messages()
    {
       return [
            'new_password.required'             => 'Please enter new password!',
            'new_password.min'                  => 'New password must be at least 6 characters!',
            'new_confirm_password.required'     => 'Please confirm your password!',
            'new_confirm_password.same'         => 'Please re-confirm your password!',
       ];
    }
}
