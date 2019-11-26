<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Hris;
use App\Http\Requests\AttendancePost;
use App\Mail\Attendance as AttendanceEmail;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = new Attendance;
        $hris = new Hris;
        
        $where = (object) array(
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'section' => "MANUFACTURING INFORMATION TECHNOLOGY"
        );

        $hris_attendances = $hris->attendances($where);
        $mms_attendances = $attendances->today(date("Y-m-d"));
        $result = array();

        foreach ($mms_attendances as $mss_key => $mss_value) 
        {
            
            foreach ($hris_attendances as $hris_key => $hris_value) 
            {
                if($mss_value->users_id == $hris_value->emp_pms_id)
                {
                    $hris_data = [
                        'last_name' => $hris_value->emp_last_name,
                        'first_name' => $hris_value->emp_first_name,
                        'middle_name' => $hris_value->emp_middle_name,
                        'emp_pms_id' => $hris_value->emp_pms_id,
                        'position' => $hris_value->position,
                        'sh_destination' => $hris_value->sh_destination,
                        'employment_type' => $hris_value->employment_type,
                        'time_in' => $hris_value->TIME_IN,
                        'time_out' => $hris_value->TIME_OUT,
                        'work_date' => $hris_value->WORKDATE,
                    ];
                    array_push($result, array_merge((array) $mss_value, $hris_data));
                }
            }
        }

        return response()->json($result);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  $request->dt_start_date
     * @param  $request->slc_section
     * @return response TRUE/FALSE
     */
    public function store(AttendancePost $input_request)
    {
        if ($input_request->validator->fails()) {
            return response()->json($input_request->validator->errors());
        }

        $attendances = new Attendance;
        $hris = new Hris;
        
        $where = (object) array(
            'start_date' => date("Y-m-d", strtotime($input_request->start_date)),
            'end_date' => date("Y-m-d", strtotime($input_request->start_date)),
            'section' => $input_request->section
        );

        
        $hris_attendances = $hris->attendances($where);
        $attendances_data = array();

        if (count($hris_attendances) > 0) {
            foreach ($hris_attendances as $key => $employee) {
                $attendance_status = ($employee->WORKDATE === null)? 'ABSENT' : 'PRESENT';

                array_push($attendances_data, [
                    'users_id' => $employee->emp_pms_id,
                    'date' => date("Y-m-d", strtotime($input_request->start_date)),
                    'status' => $attendance_status,
                    'created_at' => Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }
            
            $result = $attendances->insert_data($attendances_data);

            if ($result) {
                return response()->json(['result' => true, 'message' => 'Attendance successfully inserted.']);
            } else {
                return response()->json(['result' => false, 'message' => 'Unable to insert the Attendance.']);
            }
        } else {
            return response()->json(['result' => false, 'message' => 'Unable to get the Attendance.']);
        }
    }

    /**
     * Display the specified resource.
     * @param  Request input [start_date, end_date, section]
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(AttendancePost $input_request, Attendance $attendance)
    {
        if ($input_request->validator->fails()) {
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }

        $attendances = new Attendance;
        $hris = new Hris;

        $where = (object) array(
            'start_date' => date("Y-m-d", strtotime($input_request->start_date)),
            'end_date' => date("Y-m-d", strtotime($input_request->end_date)),
            'section' => $input_request->section
        );

        $hris_attendances = $hris->attendances($where);

        return response()->json($hris_attendances);
    }

    public function store_today_mit()
    {
        $attendances = new Attendance;
        $hris = new Hris;

        $where = (object) array(
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'section' => "MANUFACTURING INFORMATION TECHNOLOGY"
        );

        $hris_attendances = $hris->attendances($where);
        $attendances_data = array();

        if (count($hris_attendances) > 0) {
            foreach ($hris_attendances as $key => $employee) {
                $attendance_status = ($employee->WORKDATE === null)? 'ABSENT' : 'PRESENT';

                array_push($attendances_data, [
                    'users_id' => $employee->emp_pms_id,
                    'date' => date("Y-m-d"),
                    'status' => $attendance_status,
                    'created_at' => Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }
            
            $result = $attendances->insert_data($attendances_data);

            if ($result) {
                return response()->json(['result' => true, 'message' => 'Attendance successfully inserted.']);
            } else {
                return response()->json(['result' => false, 'message' => 'Unable to insert the Attendance.']);
            }
        } else {
            return response()->json(['result' => false, 'message' => 'Unable to get the Attendance.']);
        }
    }
    
    private function today_mit()
    {
        $attendances = new Attendance;
        $hris = new Hris;
        
        $where = (object) array(
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'section' => "MANUFACTURING INFORMATION TECHNOLOGY"
        );

        $hris_attendances = $hris->attendances($where);
        $mms_attendances = $attendances->today(date("Y-m-d"));
        $result = array();

        if(count($mms_attendances) == 0)
        {
            return ['result' => FALSE];
        }

        foreach ($mms_attendances as $mss_key => $mss_value) 
        {
            
            foreach ($hris_attendances as $hris_key => $hris_value) 
            {
                if($mss_value->users_id == $hris_value->emp_pms_id)
                {
                    $hris_data = [
                        'last_name' => $hris_value->emp_last_name,
                        'first_name' => $hris_value->emp_first_name,
                        'middle_name' => $hris_value->emp_middle_name,
                        'emp_pms_id' => $hris_value->emp_pms_id,
                        'position' => $hris_value->position,
                        'sh_destination' => $hris_value->sh_destination,
                        'employment_type' => $hris_value->employment_type,
                        'time_in' => $hris_value->TIME_IN,
                        'time_out' => $hris_value->TIME_OUT,
                        'work_date' => $hris_value->WORKDATE,
                    ];
                    array_push($result, array_merge((array) $mss_value, $hris_data));
                }
            }
        }

        return ['result' => TRUE, 'data' => $result];
    }

    public function email_sent()
    {
        $attendances = $this->today_mit();
        if($attendances['result'])
        {
            Mail::to('markjay.mercado@ph.fujitsu.com')->send(new AttendanceEmail($attendances['data']));
            return "Attendance email sent!";
        }
        else
        {
            return "Attendance email not send, No Data Found!";
        }
    }

    public function get_data($from, $to, Request $request)
    {
        $attendances = new Attendance;
        $hris = new Hris;

        $request->request->add(['date_from' => $from, 'date_to' => $to]); 
        $validator = Validator::make($request->all(), [
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        //getting man power of MIT in HRIS
        $man_power_where = [
            ['section_code', 'MIT'],
            ['emp_system_status', 'ACTIVE']
        ];
        $man_power_result = $hris->man_power($man_power_where);
        $mms_attendances = $attendances->select_data($from, $to);
        $result = array();

        if(count($mms_attendances) == 0)
        {
            return response()->json(['result' => FALSE, 'attendances' => []]);
        }

        foreach ($mms_attendances as $mss_key => $mss_value) 
        {
            foreach ($man_power_result as $man_key => $man_value) 
            {
                if($mss_value->users_id == $man_value->emp_pms_id)
                {
                    $man_data = [
                        'last_name' => $man_value->emp_last_name,
                        'first_name' => $man_value->emp_first_name,
                        'middle_name' => $man_value->emp_middle_name,
                        'emp_pms_id' => $man_value->emp_pms_id,
                        'position' => $man_value->position,
                        'shuttle_destination' => $man_value->sh_destination,
                        'employment_type' => $man_value->employment_type,
                        'photo' => $man_value->emp_photo
                    ];
                    array_push($result, array_merge((array) $mss_value, $man_data));
                }
            }
        }

        return response()->json(['result' => TRUE, 'attendances' => $result]);
    }
}