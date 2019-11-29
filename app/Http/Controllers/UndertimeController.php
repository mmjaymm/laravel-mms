<?php

namespace App\Http\Controllers;

use App\Undertime;
use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\UndertimePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UndertimeController extends Controller
{

    private function datas($data)
    {   
        $data->except('_token');
        return [
            'datetime_out'      => date("Y-m-d H:i:s", strtotime($data->datetime_in)),
            'reason'            => $data->reason,
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
    * request data required [ id, datetime_out, reason, attendances_id,users_id]
    */
    public function store(UndertimePost $input_request, Undertime $undertimes)
    {   
        $undertimes = new Undertime();
        $attendances = new Attendance();

        $return = [];
        
        if ($input_request->validator->fails()) {
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        DB::beginTransaction(); 

        try {
            //insert late
            $undertimes->insert_undertime_data($this->datas($input_request));   
            $attendance_data = [
                'status' => 'UNDERTIME'
            ];

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
    * request data required [ id]
    */
    public function edit($id, Undertime $undertimes)
    {
        $undertime_data = $undertimes->edit_data($id);

        if(count($undertime_data) > 0)
        {
            $return['result'] = TRUE;
            $return['data'] = $undertime_data[0];
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
    * request data required [ id, datetime_in, reason, attendances_id,users_id]
    */
    public function update($id, UndertimePost $input_request, Undertime $undertimes)
    {
        if ($input_request->validator->fails()) {
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        $update_result = $undertimes->update_data($id, $this->datas($input_request));

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
    public function destroy($id, Undertime $undertimes)
    {
        $delete_result = $undertimes->update_data($id, ['is_deleted' => 1]);

        if ($delete_result) {
            $return['result'] = true;
            $return['messages'] = 'Deleted Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Delete.';
        }
        
        return response()->json($return);
    }


    public function retrieve(Request $request, Undertime $undertimes)
    {
        $result = [];
   
        if (request()->is('undertimes/deleted')) {
            $where = [
                'is_deleted' => 1
            ];
        }

        if (request()->is('undertimes/not-deleted')) {
            $where = [
                'is_deleted' => 0
            ];
        }

        if (request()->is('undertimes/all')) {
            $where = [
                'is_deleted' => 'x'
            ];
        }

        $result = $undertimes->select_data($where);

        return response()->json($result);
    }


}
