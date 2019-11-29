<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangeShuttleController extends Controller
{

    public function change_shuttle_save(Request $request)
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
}
