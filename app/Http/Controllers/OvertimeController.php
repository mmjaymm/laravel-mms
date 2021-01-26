<?php

namespace App\Http\Controllers;

use App\Hris;
use App\Overtime;
use Illuminate\Http\Request;
use App\Http\Requests\OvertimePost;
use App\Mail\OtAuthorization;
use App\Mail\OtInformation;
use App\Mail\OtCancellation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mail;

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

        //required datetime_in if not weekdays
        if ($input_request->overtime_type != 'WEEKDAYS') {
            $valid = Validator::make($input_request->all(), [
                'datetime_in' => 'required|date_format:Y-m-d H:i:s',
            ]);
            //check of failed
            if ($valid->fails()) {
                return response()->json($valid->errors());
            }
        }

        $insert_data = $this->datas($input_request);
        $insert_data = array_merge($insert_data, $this->filling_type($input_request));

        $insert_id = $overtime->insert_data($insert_data);

        if ($insert_id > 0) {
            /**
             * @description sending email authorization
             * @request $insert_id = array()
             */
            if ($insert_data['filling_type'] === "LATE" && is_array($insert_id)) {
                $this->email_authorization("markjay.mercado@ph.fujitsu.com", [$insert_id]);
            }

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

        $update_ot = $overtimes->update_data($id, $request);
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
     * @param  Request [filling_type = (optional)[LATE, ADVANCE], overtime_ids = array()]
     * @return \Illuminate\Http\Response
     */
    public function sending_email($filling_type = '', Request $request)
    {
        if (is_array($request->overtime_ids)) {
            $email_approver = "markjay.mercado@ph.fujitsu.com";
            $email_info = "markjay.mercado@ph.fujitsu.com";

            if ($filling_type === "LATE") {
                $this->email_authorization($email_approver, $request->overtime_ids);
                $this->email_information($email_info, $request->overtime_ids);
            }

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
        $man_power_result = (array) $hris->man_power($man_power_where);
        $reviewer_name1 = null;
        $a = 0;
        $data = $data->toArray();
        
        // foreach ($data as $value) {
        // foreach ($man_power_result as $man_key => $man_value) {
        //     if ($value->reviewer_id1 == $man_value->emp_pms_id) {
        //         $man_data = [
        //             'reviewer_name1' => $man_value->emp_last_name.', '.$man_value->emp_first_name
        //         ];
                    
        //         array_push($result, array_merge((array) $value, $man_data));
        //     }
        // }

        // foreach ((array) $man_power_result as $man_key => $man_value) {
        // if ($value[$key]['employee_number'] == $man_value[$man_key]['emp_pms_id']) {
        // $man_data = [
        //     'last_name' => $man_value[$man_key]['emp_last_name'],
        //     'first_name' => $man_value[$man_key]['emp_first_name'],
        //     'middle_name' => $man_value[$man_key]['emp_middle_name']
        // ];
                
        // array_merge($value, $man_data);

        // array_push($result, $a++);
                    
        // array_push($result, array_merge((array) $value, $man_data));
        // }

        // if ($value->reviewer_id1 == $man_value->emp_pms_id) {
        //     $man_data = [
        //             'reviewer_name1' => $man_value->emp_last_name.', '.$man_value->emp_first_name
        //         ];
                    
        //     array_push($result, array_merge((array) $value, $man_data));
        // }
        // }
        // }

        return $data;
    }

    private function _get_reviewer_name($result, $value, $man_power_result)
    {
        foreach ($man_power_result as $man_key => $man_value) {
            if ($value->reviewer_id1 == $man_value->emp_pms_id) {
                $man_data = [
                    'reviewer_name1' => $man_value->emp_last_name.', '.$man_value->emp_first_name
                ];
                    
                array_push($result, array_merge((array) $value, $man_data));
            }
        }
    }

    private function _get_approver_column($column_num)
    {
        switch ($column_num) {
            case 1:
                return 'reviewer_1';
                break;
            
            case 2:
                return 'reviewer_2';
                break;

            case 3:
                return 'reviewer_3';
                break;
            
            case 4:
                return 'reviewer_4';
                break;

            default:
                return null;
                break;
        }
    }
    /**
     * @param  Request [remarks]
     * @return \Illuminate\Http\Response
     */
    public function cancel($id, Request $request, Overtime $overtimes)
    {
        $validator = Validator::make($request->all(), [
            'remarks' => 'required'
        ]);
        //check of failed
        if ($validator->fails()) {
            $return['result'] = 'data-not-valid';
            $return['request'] = $validator->errors();
            return response()->json($return);
        }

        $update_data = [
            'ot_status' => 3,
            'remarks' => $request->remarks
        ];

        $cancel_ot = $overtimes->cancelled($id, $update_data);
        $return = [];

        if ($cancel_ot) {
            $return['result'] = true;
            $return['messages'] = 'Cancelled Successfully';
        } else {
            $return['result'] = false;
            $return['messages'] = 'Unabled to Cancel.';
        }
        
        return response()->json($return);
    }
    /**
     * @param  Request [overtime_ids = array()]
     * @return \Illuminate\Http\Response
     */
    public function cancellation_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'overtime_ids' => 'required|array'
        ]);
        //check of failed
        if ($validator->fails()) {
            $return['result'] = 'data-not-valid';
            $return['request'] = $validator->errors();
            return response()->json($return);
        }

        if (auth()->user()->roles->level === "ADMIN") {
            $email_to = "markjay.mercado@ph.fujitsu.com";
            $return = $this->email_cancellation($email_to, $request->overtime_ids);
        } else {
            $return['result'] = false;
            $return['messages'] = 'Need administrator permission to send this email.';
        }

        return response()->json($return);
    }

    private function email_cancellation($email_to, $ids)
    {
        Mail::to($email_to)->send(new OtCancellation($ids));

        if (Mail::failures()) {
            return ['result' => false, 'messages' => 'Email not sent!'];
        } else {
            return ['result' => true, 'messages' => 'Email sent successfully!'];
        }
    }

    /**
     * @param  status = "approve","decline"
     * @param  Request [remarks (for decline only), reviewer_column = 1/2/3/4, overtime_ids = array()]
     * @return \Illuminate\Http\Response
     */
    public function authorization($status, Request $request, Overtime $overtimes)
    {
        $return = [];

        if ($status == 'approve' || $status == 'decline') {
            $validator = Validator::make($request->all(), [
                'overtime_ids' => 'required|array',
                'reviewer_column' => 'required|integer'
            ]);
            
            if (isset($request->remarks)) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('remarks', 'required');
                });
            }

            //check of failed
            if ($validator->fails()) {
                $return['result'] = 'data-not-valid';
                $return['request'] = $validator->errors();
                return response()->json($return);
            }

            $data_status = $this->_get_authorization_status($status);
            $reviewer_column = $this->_get_approver_column($request->reviewer_column);

            $update_data = [
                'ot_status' => $data_status['ot_status'],
                $reviewer_column => auth()->user()->id,
            ];

            $update_result = $overtimes->update_multiple($request->overtime_ids, $update_data);

            if ($update_result > 0) {
                $reviewer_email = "markjay.mercado@ph.fujitsu.com";
                $this->email_authorization($reviewer_email, $request->overtime_ids);

                $return['result'] = true;
                $return['messages'] =  "{$data_status['message_success']} Successfully";
            } else {
                $return['result'] = false;
                $return['messages'] = "Unabled to {$data_status['message_error']}.";
            }
        } else {
            $return['result'] = 'uri-not-valid';
            $return['request'] = 'URI parameter for OT status is not available.';
        }

        return response()->json($return);
    }

    private function _get_authorization_status($status)
    {
        switch ($status) {
            case 'approve':
                return ['ot_status' => 1, 'message_success' => 'Approved', 'message_error' => 'Approve'];
                break;
            
            case 'decline':
                return ['ot_status' => 2, 'message_success' => 'Declined', 'message_error' => 'Decline'];
                break;

            default:
                return null;
                break;
        }
    }
}