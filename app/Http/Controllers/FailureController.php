<?php

namespace App\Http\Controllers;

use App\Hris;
use App\Failure;
use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\FailurePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FailureController extends Controller
{
    public function retrieve_attendance_id()
    {
        $users_id = Auth::user()->id;

        $attedance_id = new Failure();
        $result = $attedance_id->attendance_id_data($users_id);

        return $result;
    }


    private function datas($data)
    {   
        $data->except('_token');
        $latest_attendance_id = $this->retrieve_attendance_id();
        return [
            'datetime_in'       => date("Y-m-d H:i:s", strtotime($data->datetime_in)),
            'datetime_out'      => date("Y-m-d H:i:s", strtotime($data->datetime_out)),
            'reason'            => $data->reason,
            'date_filed'        => Carbon::now(),
            'users_id'          => Auth::user()->id,
            'attendances_id'    => $latest_attendance_id->id
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
            $attendances->update_data($input_request->id, $attendance_data) ;
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
    * request data required [ id]
    */
    public function edit($id, Failure $failure)
    {
        $failure_data = $failure->edit_data($id);

        if(count($failure_data) > 0)
        {
            $return['result'] = TRUE;
            $return['data'] = $failure_data[0];
            $return['messages'] = 'Data Found.';
        }
        else
        {
            $return['result'] = FALSE;
            $return['data'] = [];
            $return['messages'] = 'No Data Found.';   
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

        if (Auth::user()->roles->level === "USER") 
        {
            $return = ['level' => Auth::user()->roles->level, 'data' => $failures->select_data()];
        } 
        else 
        {
            $failure_data = $failures->select_data($failures);
            $failure_users = $this->combine_data_to_manpower($failure_data);
            $return = ['level' => Auth::user()->roles->level, 'data' => $failure_users];
        }
        return response()->json($return);
    }

    private function combine_data_to_manpower($data)
    {
        $result = [];
        $hris = new Hris;
        //getting man power of MIT in HRIS
        $man_power_where = [
            ['section_code', 'MIT'],
            ['emp_system_status', 'ACTIVE']
        ];
        $man_power_result = $hris->man_power($man_power_where);

        foreach ($data as $key => $value) {
            foreach ($man_power_result as $man_key => $man_value) {
                if ($value->employee_number == $man_value->emp_pms_id) {
                    $man_data = [
                        'last_name' => $man_value->emp_last_name,
                        'first_name' => $man_value->emp_first_name,
                        'middle_name' => $man_value->emp_middle_name,
                    ];
                    array_push($result, array_merge((array) $value, $man_data));
                }
            }
        }

        return $result;
    }

}
