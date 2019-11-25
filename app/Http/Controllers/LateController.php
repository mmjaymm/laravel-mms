<?php

namespace App\Http\Controllers;

use App\Late;
use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\LatePost;
use Illuminate\Support\Facades\DB;

class LateController extends Controller
{
    private function datas($data)
    {
        return [
            'datetime_in' => $data->datetime_in,
            'reason' => $data->reason
        ];
    }

    public function index()
    {
        return csrf_token();
    }

    public function store(LatePost $input_request, Late $lates)
    {   
        $attendances = new Attendance;
        $return = [];

        if ($input_request->validator->fails()) {
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        DB::beginTransaction(); 

        try {
            //insert late
            $late_id = $lates->insert_data($this->datas($input_request));   
            $attendance_data = [
                'status_id' => $late_id,
                'status' => 'LATE'
            ];
            //update status in attendance
            $attendances->update_data($input_request->attendances_id, $attendance_data) ;
            DB::commit();

            $return['result'] = TRUE;
            $return['messages'] = 'Inserted Successfully.';

        } catch (\Throwable $th) {
            DB::rollback();

            $return['result'] = FALSE;
            $return['messages'] = 'Unable to Insert';
        }
        
        return response()->json($return);
    }
}