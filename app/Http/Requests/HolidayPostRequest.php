<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayPostRequest extends FormRequest
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
            'holiday_name'   => 'required|string|max:50',
            'holiday_date'   => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'holiday_name.required'   => 'Please enter holiday name!',
            'holiday_name.string'     => 'Holiday name must be in string format!',
            'holiday_name.max'        => 'You have exceeded the maximum characters (50) for holiday name.',
            'holiday_date.required'   => 'Please enter holiday date!',
            'holiday_date.date'       => 'Holiday date must be in date format!',
        ];
    }
}
