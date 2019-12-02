<?php

namespace App\Http\Controllers;

use App\ChangeShuttle;
use Illuminate\Http\Request;
use App\Http\Requests\ChangeShuttlePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
            'control_number'        => $data->control_number
            
        ];
    }


    public function latest_control_number()
    {

        $result = [];

        $control_number = new ChangeShuttle();
        $result = $control_number->retrieve_control();

        return json_decode($result);

    }


     /*
    * return @array
    * request data required [ users_id, datetime_in, reason, date_schedule, shuttle_status,shuttle_location_id,control_number]
    */
    public function store(ChangeShuttlePost $input_request, ChangeShuttle $change)
    {
        
        $return = [];

        if ($input_request->validator->fails()) {
            $return['result'] = false;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

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


    public function retrieve_today(ChangeShuttle $change)
    {
        $result = [];

        $result = $change->retrieve_one($change);
 
        return response()->json($result);
    }

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


}
