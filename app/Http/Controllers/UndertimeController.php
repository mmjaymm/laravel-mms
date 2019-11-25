<?php

namespace App\Http\Controllers;

use App\Undertime;

use Illuminate\Http\Request;

use Validator;

class UndertimeController extends Controller
{

    public function validate()
    {
        $rules = array(
            'txt_datetime_out'      => 'required',
            'txt_reason'            => 'required'
        );

        $error = Validator::make(request()->all(), $rules);
        return $error;
    }
    
    public function insert_undertime(Request $request)
    {
        
        $error_validate = $this->validate();

        if($error_validate->fails())
        {
            return response()->json(['errors' => $error_validate->errors()->all()]);
        }

        $undertime_data = $request->except('_token');
        $undertime_data = array(
            
            'txt_datetime_out'      =>$request->txt_datetime_out,
            'txt_reason'            =>$request->txt_reason,

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

        $error_validate = $this->validate();

        if($error_validate->fails())
        {
            return response()->json(['errors' => $error_validate->errors()->all()]);
        }

        $undertime_data = $request->except('_token');
        $undertime_data = array(
            'txt_date'              =>$request->txt_date,
            'txt_status'            =>$request->txt_status

        );

        $update_data = new Undertime();
        return $update_data->edit_undertime($undertime_data,$id);
  
    }


}
