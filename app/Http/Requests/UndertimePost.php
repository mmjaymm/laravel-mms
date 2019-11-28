<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UndertimePost extends FormRequest
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
            'users_id' => 'required',
            'attendances_id' => 'required',
            'datetime_out' => 'required|date_format:Y/m/d H:i:s',
            'reason' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'users_id.required' => 'Userid is required!',
            'attendances_id.required' => 'Attendance record is required!',
            'datetime_out.required' => 'Time in is required!',
            'datetime_out.date' => 'Please insert valid time in format!',
            'reason.required' => 'Reason is required!',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
