<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvertimePost extends FormRequest
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
            'overtime_type' => 'required',
            'datetime_out' => 'required|date_format:Y-m-d H:i:s',
            'reason' => 'required',
        ];
    }

     public function messages()
    {
        return [
            'users_id.required' => 'User is required!',
            'overtime_type.required' => 'Overtime type is required!',
            'datetime_out.required' => 'Time out is required!',
            'datetime_out.date' => 'Please insert valid time in format!',
            'reason.required' => 'Reason is required!',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}