<?php

namespace App\Http\Controllers;

use App\Overtime;
use Illuminate\Http\Request;
use App\Http\Requests\OvertimePost;
use App\Mail\OtAuthorization;
use Illuminate\Support\Facades\Validator;

class OvertimeController extends Controller
{
    private $weekdays_cutoff = '11:00';
    private $weekends_cutoff = '10:00';

    private function datas($data)
    {
        return [
            'users_id' => $data->users_id,
            'overtime_type' => $data->overtime_type,
            'datetime_out' => date("Y-m-d H:i:s", strtotime($data->datetime_out)),
            'reason' => $data->reason
        ];
    }

    public function index()
    {
    }
    /*
    * return @array
    * request data required [ users_id, overtime_type, datetime_out, reason]
    */
    public function store(OvertimePost $input_request, Overtime $overtime)
    {
        if ($input_request->validator->fails()) {
            $return['result'] = false;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        $insert_data = $this->datas($input_request);
        $insert_data = array_merge($insert_data, $this->filling_type($input_request));

        $insert_id = $overtime->insert_data($insert_data);

        if ($insert_data['filling_type'] === "LATE") {
            //change email send to
            $email_to = "markjay.mercado@ph.fujitsu.com";
            $this->email_authorization($email_to, $insert_id);
        }

        
        if ($insert_id > 0) {
            $return['result'] = true;
            $return['messages'] = 'Inserted Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Insert.';
        }

        return response()->json($return);
    }

    private function filling_type($input_request)
    {
        if ($input_request->overtime_type === 'WEEKDAYS') {
            $filling_type = (date("H:i") <= $this->weekdays_cutoff) ? "ADVANCE" : "LATE";
            $datetime_in = null;
        } else {
            $filling_type = (date("H:i") <= $this->weekends_cutoff) ? "ADVANCE" : "LATE";
            $datetime_in = date("Y-m-d H:i:s", strtotime($input_request->datetime_in));
        }

        return [
            'filling_type' => $filling_type,
            'datetime_in' => $datetime_in
        ];
    }
    
    private function email_authorization($email_to, $id)
    {
        Mail::to($email_to)->send(new OtAuthorization($id));
    }
    /**
     *
     * @param  Request input [users_id, overtime_type, datetime_out, reason, filling_type]
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Overtime $overtimes)
    {
        $return = [];

        $request->offsetUnset('_token');
        $request->offsetUnset('_method');

        $validator = Validator::make($request->all(), [
            'users_id' => 'required|integer',
            'overtime_type' => 'required',
            'datetime_out' => 'required|date_format:Y-m-d',
            'reason' => 'required',
            'filling_type' => 'required',
        ]);
        //check of failed
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        //check if pending to approve
        $is_pending = $this->is_pending_to_approved($id);

        if (!$is_pending) {
            $return['result'] = false;
            $return['messages'] = "Unable to Update. Ang OT request mo ay inaapprove pa.";

            return response()->json($return);
        }

        $update_ot = $ovetimes->update_data($id, $request);
        if ($update_ot > 0) {
            $return['result'] = true;
            $return['messages'] = "Updated Successfully.";
        } else {
            $return['result'] = false;
            $return['messages'] = "Unable to Update.";
        }
        
        return response()->json($request);
    }

    private function is_pending_to_approved($id)
    {
        $ovetimes = new Overtime;
        $where = [
            ['id', '=', $id],
            ['reviewer_1', '=', null],
            ['reviewer_2', '=', null],
            ['reviewer_3', '=', null],
            ['reviewer_4', '=', null]
        ];

        $result = $ovetimes->select_data($where);

        return (count($result) > 0) ? true : false;
    }
}