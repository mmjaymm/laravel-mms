<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Failure;

use Validator;

class FailureController extends Controller
{

    public function index()
    {
        return csrf_token();
    }


    public function failure_insert(Request $request)
    {
        
        $rules = array(
            'txt_datetime_in'       => 'required',
            'txt_datetime_out'      => 'required',
            'txt_reason'            => 'required',
            'txt_date_filed'        => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $failure_data = $request->except('_token');
        $failure_data = array(
            
            'txt_datetime_in'       =>$request->txt_datetime_in,
            'txt_datetime_out'      =>$request->txt_datetime_out,
            'txt_reason'            =>$request->txt_reason,
            'file_date_filed'       =>$request->txt_date_filed

        );

        $data = new Failure();
        return $data->insert_failure_login($failure_data);


    }

    public function failure_login_data()
    {

        $failure_output = new Failure();
        return $failure_output->select_failure_login();

    }


    public function update_attendance(Request $request, $id)
    {

        $rules = array(
            'txt_date'              => 'required',
            'txt_status'            => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $attendance_data = $request->except('_token');
        $attendance_data = array(
            'txt_date'              =>$request->txt_date,
            'txt_status'            =>$request->txt_status

        );

        $update_data = new Failure();
        return $update_data->edit_attendance_failure($attendance_data,$id);

        
    }
}
  