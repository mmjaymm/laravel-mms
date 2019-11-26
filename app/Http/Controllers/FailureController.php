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
            'datetime_in'       => 'required',
            'datetime_out'      => 'required',
            'reason'            => 'required',
            'date_filed'        => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $failure_data = $request->except('_token');
        $failure_data = array(
            
            'datetime_in'       =>$request->datetime_in,
            'datetime_out'      =>$request->datetime_out,
            'reason'            =>$request->reason,
            'date_filed'        =>$request->date_filed

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
            'attendance_date'              => 'required',
            'attendance_status'            => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $attendance_data = $request->except('_token','_method');
        $attendance_data = array(
            'attendance_date'              =>$request->attendance_date,
            'attendance_status'            =>$request->attendance_status

        );

        $update_data = new Failure();
        return $update_data->edit_attendance_failure($attendance_data,$id);

        
    }
}
  