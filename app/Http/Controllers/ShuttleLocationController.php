<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ShuttleLocation;
use Carbon\Carbon;
use Validator;

class ShuttleLocationController extends Controller
{

    private function datas($data)
    {
        $data->except('_token','_method');
        return [
            'shuttle_location' => $data->shuttle_location,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    public function index()
    {

        return csrf_token();
    }


    /*
    * return @array
    * request data required [shuttle_location]
    */
    public function store(Request $request, ShuttleLocation $location)
    {

        $validator = Validator::make($request->all(), [
            'shuttle_location' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        else{

            DB::beginTransaction();

            try {
                //insert shuttle
                $location = new ShuttleLocation();
                $location->insert_data($this->datas($request));
                DB::commit();
    
                $return['result'] = true;
                $return['messages'] = 'Inserted Successfully.';
            } catch (\Throwable $th) {
                DB::rollback();
    
                $return['result'] = false;
                $return['messages'] = 'Unable to Insert';
            }
            
            return response()->json($return);

        }
   
    }


    /*
    * return @array
    * request data required [id]
    */
    public function edit($id, ShuttleLocation $location)
    {
        $shuttle_data = $location->edit_data($id);

        if (count($shuttle_data) > 0) {
            $return['result'] = true;
            $return['data'] = $shuttle_data[0];
            $return['messages'] = 'Data Found.';
        } else {
            $return['result'] = false;
            $return['data'] = [];
            $return['messages'] = 'No Data Found.';
        }

        return response()->json($return);
    }


    /*
    * return @array
    * _method PUT
    * request data required [ id, shuttle_location]
    */
    public function update($id, Request $request, ShuttleLocation $location)
    {
        $validator = Validator::make($request->all(), [
            'shuttle_location' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        else
        {

            $update_result = $location->update_data($id, $this->datas($request));

            if ($update_result) {
                $return['result'] = true;
                $return['messages'] = 'Updated Successfully';
            } else {
                $return['result'] = false;
                $return['messages'] = 'Unabled to Update.';
            }
            
            return response()->json($return);
        }
    }


    /*
    * return @array
    * request data required [ id]
    */
    public function destroy($id, ShuttleLocation $location)
    {
        $delete_result = $location->update_data($id, ['is_deleted' => 1]);

        if ($delete_result) {
            $return['result'] = true;
            $return['messages'] = 'Deleted Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Delete.';
        }
        
        return response()->json($return);
    }


    public function retrieve(ShuttleLocation $location)
    {
        $result = [];

       $result = $location->select_data($location);

        return response()->json($result);
    }

    public function retrieve_default_shuttle(ShuttleLocation $location)
    {
        $result = [];

        $result = $location->default_location($location);
 
        return response()->json($result);
 
    }
      
}

