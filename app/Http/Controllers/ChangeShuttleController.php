<?php

namespace App\Http\Controllers;

use App\ChangeShuttle;
use Illuminate\Http\Request;
use App\Http\Requests\ChangeShuttlePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ChangeShuttleController extends Controller
{


    private function datas($data)
    {

        return [
            'users_id'              => $data->users_id,
            'reason'                => $data->reason,
            'datetime_schedule'     => $data->datetime_schedule,
            'shuttle_status'        => $data->shuttle_status,
            'shuttle_location_id'   => $data->shuttle_location_id,
            //'control_number'        => $data->control_number,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now()
            
        ];
    }


    public function latest_control_number()
    {

        $result = [];

        $control_number = new ChangeShuttle();
        $result = $control_number->retrieve_control();

        return $result;

    }


     /*
    * return @array
    * request data required [ users_id, datetime_in, reason, date_schedule, shuttle_status,shuttle_location_id]
    */
    public function store(ChangeShuttlePost $input_request, ChangeShuttle $change)
    {
        
        $return = [];

        if ($input_request->validator->fails()) {
            $return['result'] = false;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        $lates_control_number = str_replace("MIT","",$this->latest_control_number()->control_number);
        $input_request["control_number"] = "MIT".($lates_control_number+1);

        DB::beginTransaction();
        try {
            //insert change shuttle
            $change = new ChangeShuttle();
            $change->insert_data($this->datas($input_request));
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


     /*
    * return @array
    * _method PUT
     * request data required [ users_id, datetime_in, reason, date_schedule, shuttle_status,shuttle_location_id,control_number]
    */
    public function update($id, ChangeShuttlePost $input_request, ChangeShuttle $change)
    {
        if ($input_request->validator->fails()) {
            $return['result'] = false;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        $input_request->except('control_number','_token','_method');
        $update_result = $change->update_data($id, $this->datas($input_request));

        if ($update_result) {
            $return['result'] = true;
            $return['messages'] = 'Updated Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Update.';
        }
        
        return response()->json($return);
    }

    public function retrieve_today()
    {

        $result = [];

        $change = new ChangeShuttle();
        $result = $change->select_shuttles_today();

        return response()->json($result);

    }

    /*
    * return @array
    * request data required [id]
    */

    public function destroy($id, ChangeShuttle $change)
    {
        $delete_result = $change->update_data($id, ['is_deleted' => 1]);

        if ($delete_result) {
            $return['result'] = true;
            $return['messages'] = 'Deleted Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Delete.';
        }
        
        return response()->json($return);
    }


    /*
    * return @array
    * request data required [date_schedule,shuttle_location]
    */

    public function retrieve(Request $request,ChangeShuttle $change)
    {
        $result = [];
        $validator = Validator::make($request->all(), [
            'date_search'    => 'required|date_format:Y-m-d',
            'location'       => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
 
        if (request()->is('change/shuttles/location')) {
            $where = [
                'location'       => $request->location,
                'date_search'    => $request->date_search,
                'is_deleted'     => 0
            ];
        }

        if (request()->is('change/shuttles/all')) {
            $where = [
                'location'      => $request->location,
                'date_search'   => $request->date_search,
                'is_deleted'    => 'x'
            ];
        }

        $result = $change->select_data($where);

        return response()->json($result);
    }

}
