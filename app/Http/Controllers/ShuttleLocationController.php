<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ShuttleLocation;

use Validator;

class ShuttleLocationController extends Controller
{
    
    public function add_shuttle_location(Request $request)
    {

        return $request;

        $rules = array(
            'shuttle_location'  => 'required'
            
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
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


    }

    public function edit_shuttle_location()
    {


    }
}
