<?php

namespace App\Http\Controllers;

use App\ChangeShuttle;
use Illuminate\Http\Request;
use App\Http\Requests\ChangeShuttlePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ChangeShuttleController extends Controller
{

    protected $control_number = "MIT0698";

    private function datas($data)
    {

        $control_number = 'MIT0698';
        return [
            'users_id'              => $data->users_id,
            //'reason' => $data->reason,
            'date_schedule'         => $data->date_schedule,
            'shuttle_status'        => $data->shuttle_status,
            'shuttle_location_id'   => $data->shuttle_location_id,
            'control_number'        => $control_number++,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now()
            
        ];
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


}
