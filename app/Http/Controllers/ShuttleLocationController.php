<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ShuttleLocation;

use Validator;

class ShuttleLocationController extends Controller
{


    public function validate_input()
    {
        $rules = array(
            'shuttle_location'  => 'required'
            
        );

        $error = Validator::make(request()->all(), $rules);
        return $error;
    }
    
    public function add_shuttle_location(Request $request)
    {


        $error_validate = $this->validate_input();

        if($error_validate->fails())
        {
            return response()->json(['errors' => $error_validate->errors()->all()]);
        }

        $shuttle_data = array(
            
            'shuttle_location'   =>$request->shuttle_location


        );

        $shuttle_data = $request->except('_token');
        $data = new ShuttleLocation();
        return $data->insert_shuttle_location($shuttle_data);


    }

    public function show_shuttle_location()
    {

        $shuttle_output = new ShuttleLocation();
        return $shuttle_output->load_shuttle_location();

    }

    public function edit_shuttle_location(Request $request,$id)
    {

        return $request;

        $error_validate = $this->validate_input();

        if($error_validate->fails())
        {
            return response()->json(['errors' => $error_validate->errors()->all()]);
        }

        $shuttle_data = array(
            
            'shuttle_location'   =>$request->shuttle_location
        );

        $shuttle_data = $request->except('_token','_method');
        $data = new ShuttleLocation();
        return $data->update_shuttle_location($shuttle_data,$id);

    }
}
