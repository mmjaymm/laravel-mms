<?php

namespace App\Http\Controllers;

use App\Hris;
use App\Overtime;
use Illuminate\Http\Request;
use App\Http\Requests\OvertimePost;
use App\Mail\OtAuthorization;
use App\Mail\OtInformation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    private $weekdays_cutoff = '11:00';
    private $weekends_cutoff = '10:00';

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index']]);
    }

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
        return view('pages.Overtime.overtime');
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

        $insert_result = $overtime->insert_data($insert_data);
        
        if ($insert_result) {
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
    
    private function email_authorization($email_to, $ids)
    {
        Mail::to($email_to)->send(new OtAuthorization($ids));
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
    /**
     *
     * @param  Request input [_token, txt_date_from, txt_date_to]
     * @return \Illuminate\Http\Response
     */
    public function retrieve(Request $request, Overtime $overtimes)
    {
        $validator = Validator::make($request->all(), [
            'txt_date_from' => 'required|date_format:Y-m-d',
            'txt_date_to' => 'required|date_format:Y-m-d'
        ]);
        //check of failed
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (Auth::user()->roles->level === "USER") {
            $where = [
                'date_from' => $request->txt_date_from,
                'date_to' => $request->txt_date_to,
                'condition' => [['a.users_id', '=', Auth::user()->id]]
            ];

            $return = ['level' => Auth::user()->roles->level, 'data' => $overtimes->select_data($where)];
        } else {
            $where = [
                'date_from' => $request->txt_date_from,
                'date_to' => $request->txt_date_to,
                'condition' => []
            ];

            $overtime_data = $overtimes->select_data($where);
            $overtime_users = $this->combine_data_to_manpower($overtime_data);
            $return = ['level' => Auth::user()->roles->level, 'data' => $overtime_users];
        }

        return response()->json($return);
    }

    /**
     *
     * @param  Request [overtime_ids = array()]
     * @return \Illuminate\Http\Response
     */
    public function sending_email(Request $request)
    {
        if (is_array($request->overtime_ids)) {
            $email_approver = "markjay.mercado@ph.fujitsu.com";
            $email_info = "markjay.mercado@ph.fujitsu.com";

            $this->email_authorization($email_approver, $request->overtime_ids);
            $this->email_information($email_info, $request->overtime_ids);

            return response()->json(['result' => true, 'message' => 'Email Sent.']);
        } else {
            return response()->json(['result' => false, 'message' => 'Please required Overtime id.']);
        }
    }

    private function email_information($email_to, $ids)
    {
        Mail::to($email_to)->send(new OtInformation($ids));
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