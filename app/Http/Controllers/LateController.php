<?php

namespace App\Http\Controllers;

use App\Late;
use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\LatePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LateController extends Controller
{
    private function datas($data)
    {
        return [
            'datetime_in' => date("Y-m-d H:i:s", strtotime($data->datetime_in)),
            'reason' => $data->reason,
            'attendances_id' => $data->attendances_id,
            'users_id' => $data->users_id
        ];
    }

    public function mms_token()
    {
        return csrf_token();
    }

    public function index()
    {
    }

    /*
    * return @array
    * request data required [ id, datetime_in, reason, attendances_id, users_id]
    */
    public function store(LatePost $input_request, Late $lates)
    {
        $attendances = new Attendance;
        $return = [];

        if ($input_request->validator->fails()) {
            $return['result'] = false;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        DB::beginTransaction();

        try {
            //insert late
            $late_inserted = $lates->insert_data($this->datas($input_request));
            $attendance_data = ['status' => 'LATE'];

            //update status in attendance
            $attendances->update_data($input_request->attendances_id, $attendance_data) ;
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
    * request data required [id]
    */
    public function edit($id, Late $lates)
    {
        $late_data = $lates->edit_data($id);

        if (count($late_data) > 0) {
            $return['result'] = true;
            $return['data'] = $late_data[0];
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
    * request data required [ id, datetime_in, reason, attendances_id, users_id]
    */
    public function update($id, LatePost $input_request, Late $lates)
    {
        if ($input_request->validator->fails()) {
            $return['result'] = false;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        $update_result = $lates->update_data($id, $this->datas($input_request));

        if ($update_result) {
            $return['result'] = true;
            $return['messages'] = 'Updated Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Update.';
        }
        
        return response()->json($return);
    }

    /*
    * return @array
    * request data required [ id]
    */
    public function destroy($id, Late $lates)
    {
        $delete_result = $lates->update_data($id, ['is_deleted' => 1]);

        if ($delete_result) {
            $return['result'] = true;
            $return['messages'] = 'Deleted Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Delete.';
        }
        
        return response()->json($return);
    }

    public function retrieve(Request $request, Late $lates)
    {
        $result = [];
        $validator = Validator::make($request->all(), [
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
 
        if (request()->is('lates/deleted')) {
            $where = $this->_retrieve_where_user_permissions($request, 1);
        }

        if (request()->is('lates/not-deleted')) {
            $where = $this->_retrieve_where_user_permissions($request, 0);
        }

        if (request()->is('lates/all')) {
            $where = $this->_retrieve_where_user_permissions($request, 'x');
        }

        $result = $lates->select_data($where);

        return response()->json($result);
    }

    private function _retrieve_where_user_permissions($request, $is_deleted)
    {
        if (Auth::user()->roles->level === "USER") {
            return [
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'where' => [
                    ['is_deleted', '=', $is_deleted],
                    ['users_id', '=', auth()->user()->id]
                ],
                'is_deleted' => $is_deleted
            ];
        } else {
            return [
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'where' => [
                    ['is_deleted', '=', $is_deleted]
                ],
                'is_deleted' => $is_deleted
            ];
        }
    }
}