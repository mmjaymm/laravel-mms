<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FailurePost extends FormRequest
{

    public $validator = null;
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
            'attendances_id' => 'required',
            'users_id'       => 'required',
            'datetime_out'   => 'required|date_format:Y/m/d H:i:s',
            'datetime_in'    => 'required|date_format:Y/m/d H:i:s',
            'reason'         => 'required'
        ];
    }

    public function messages()
    {
        return [
            'attendances_id.required' => 'Attendance record is required!',
            'users_id.required' => 'Users id is required!',
            'datetime_out.required' => 'Time in is required!',
            'datetime_out.date' => 'Please insert valid time in format!',
            'datetime_in.required' => 'Time in is required!',
            'datetime_in.date' => 'Please insert valid time in format!',
            'reason.required' => 'Reason is required!',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
