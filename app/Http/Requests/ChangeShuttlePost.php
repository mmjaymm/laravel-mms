<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeShuttlePost extends FormRequest
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
            'users_id'              => 'required',
            'date_schedule'     => 'required|date_format:Y/m/d',
            'shuttle_status'        => 'required',
            'shuttle_location_id'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'users_id.required'             => 'Changed Shuttle is required!',
            'date_schedule.required'    => 'Date Time in is required!',
            'date_schedule.date'        => 'Please insert valid time in format!',
            'shuttle_status.required'       => 'Status is required!',
            'shuttle_location_id.required'  => 'Changed Shuttle is required!'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
