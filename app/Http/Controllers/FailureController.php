<?php

namespace App\Http\Controllers;

use App\Failure;
use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\FailurePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FailureController extends Controller
{
    private function datas($data)
    {   
        $data->except('_token');
        return [
            'datetime_in'       => date("Y-m-d H:i:s", strtotime($data->datetime_in)),
            'datetime_out'      => date("Y-m-d H:i:s", strtotime($data->datetime_out)),
            'reason'            => $data->reason,
            'date_filed'         => Carbon::now(),
            'attendances_id'    => $data->attendances_id, 
            'users_id'          => $data->users_id
        ];
    }

    public function index()
    {
        return csrf_token();

    }


    /*
    * return @array
    * request data required [ id,datetime_out, datetime_in, reason, attendances_id]
    */

    public function store(FailurePost $input_request, Failure $failures)
    {

        $failures = new Failure();
        $attendances = new Attendance();
        $return = [];


        if ($input_request->validator->fails()) {
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        DB::beginTransaction(); 

        try {
            //insert failures
            
 
            $failures->insert_failure_data($this->datas($input_request));   
            $attendance_data = [
                'status' => 'FAILURE'
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


    /*
    * return @array
    * _method PUT
    * request data required [ id, datetime_in,datetime_out, reason,date_filed]
    */
    public function update($id, FailurePost $input_request, Failure $failures)
    {
        if ($input_request->validator->fails()) {
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }
        
        $update_result = $failures->update_data($id, $this->datas($input_request));

        if($update_result)
        {
            $return['result'] = TRUE;
            $return['messages'] = 'Updated Successfully';
        }
        else
        {
            $return['result'] = FALSE;
            $return['messages'] = 'Unabled to Update.';   
        }
        
        return response()->json($return);
    }


    /*
    * return @array
    * request data required [ id]
    */

    public function destroy($id, Failure $failures)
    {
        $delete_result = $failures->update_data($id, ['is_deleted' => 1]);

        if ($delete_result) {
            $return['result'] = true;
            $return['messages'] = 'Deleted Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Delete.';
        }
        
        return response()->json($return);
    }

    public function retrieve(Failure $failures)
    {
        
        $result = $failures->select_data($failures);

        return response()->json($result);
    }

}
