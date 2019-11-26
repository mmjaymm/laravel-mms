<?php

namespace App\Http\Controllers;

use App\Undertime;

use Illuminate\Http\Request;

use Validator;

class UndertimeController extends Controller
{

    public function insert_undertime(Request $request)
    {

        $rules = array(
            'datetime_out'      => 'required',
            'reason'            => 'required'
        );
        
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $undertime_data = $request->except('_token');
        $undertime_data = array(
            
            'datetime_out'          =>$request->datetime_out,
            'undertime_reason'      =>$request->reason

        );

        $data = new Undertime();
        return $data->insert_undertime_data($undertime_data);


    }

    public function get_undertime_data()
    {

        $undertime_output = new Undertime();
        return $undertime_output->show_undertime_data();

    }

    public function update_undertime(Request $request, $id)
    {

        $rules = array(
            'datetime_out'          => 'required',
            'undertime_reason'      => 'required'
        );
        
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $undertime_data = $request->except('_token','_method');
        $undertime_data = array(
            'datetime_out'              =>$request->datetime_out,
            'undertime_reason'          =>$request->undertime_reason

        );

        $update_data = new Undertime();
        return $update_data->edit_undertime($undertime_data,$id);
  
    }


}
