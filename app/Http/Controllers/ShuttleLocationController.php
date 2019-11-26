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

        $shuttle_location =[
                             
                            'BALIBAGO','STA.ROSA PROPER','CABUYAO','LOS BAÑOS',
                            'MAMATID','PARIAN','CROSSING STI','STO.TOMAS','GMA',
                            'CANLUBANG','IMPERIAL','ALABANG/SOUTHWOODS','CARMONA','OLIVAREZ'
                            
                            ];

        //KINDLY UNCOMMENT THIS PORTION TO INSERT BATCH SHUTTLE LOCATION
        
        // $data = new ShuttleLocation();

        // for($a = 0; $a < count($shuttle_location); $a++)
        // {
        //     $data->insert_shuttle_location(['shuttle_location' => $shuttle_location[$a]]);
        // }

        // return $shuttle_location;


        //KINDLY COMMENT THIS PORTION IF YOU WANT TO INSERT BATCH SHUTTLE LOCATIO
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
        $data->insert_shuttle_location($shuttle_data);

        return response()->json($shuttle_data);


    }

    public function show_shuttle_location()
    {

        $shuttle_output = new ShuttleLocation();
        return $shuttle_output->load_shuttle_location();

    }

    public function edit_shuttle_location(Request $request,$id=1)
    {

        //return $request;

        $error_validate = $this->validate_input();

        if($error_validate->fails())
        {
            return response()->json(['errors' => $error_validate->errors()->all()]);
        }

        

        $shuttle_data = $request->except('_token','_method');
        $shuttle_data = array(
            
            'shuttle_location'   =>$request->shuttle_location
        );


        $data = new ShuttleLocation();
        $data->update_shuttle_location($shuttle_data,$id);

        return response()->json($shuttle_data);

    }
}
