<?php

namespace App\Http\Controllers;

use App\Overtime;
use Illuminate\Http\Request;
use App\Http\Requests\OvertimePost;
use App\Mail\OtAuthorization;

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
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        $insert_data = $this->datas($input_request);
        $insert_data = array_merge($insert_data, $this->ot_status($input_request));

        $insert_id = $overtime->insert_data($insert_data); 

        if($insert_data['ot_status'] === "LATE")
        {
            //change email send to
            $email_to = "markjay.mercado@ph.fujitsu.com";
            $this->email_authorization($email_to, $insert_id);
        }

        if($insert_id > 0)
        {
            $return['result'] = TRUE;
            $return['messages'] = 'Inserted Successfully';
        }
        else
        {
            $return['result'] = FALSE;
            $return['messages'] = 'Unabled to Insert.';   
        }

        return response()->json($return);
    }

    private function ot_status($input_request)
    {
        if($input_request->overtime_type === 'WEEKDAYS')
        {
            $ot_status = (date("H:i") <= $this->weekdays_cutoff) ? "ADVANCE" : "LATE";
            $datetime_in = null;
        }
        else
        {
            $ot_status = (date("H:i") <= $this->weekends_cutoff) ? "ADVANCE" : "LATE";
            $datetime_in = date("Y-m-d H:i:s", strtotime($input_request->datetime_in));
        }

        return [
            'ot_status' => $ot_status,
            'datetime_in' => $datetime_in
        ];
    }
    
    private function email_authorization($email_to, $id)
    {
        Mail::to($email_to)->send(new OtAuthorization($id));
    }
}