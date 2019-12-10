<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Hris;
use App\User;
use App\Http\Requests\AttendancePost;
use App\Mail\Attendance as AttendanceEmail;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  $request->start_date
     * @param  $request->section
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

                $users = User::where('employee_number', $employee->emp_pms_id)->first();

                array_push($attendances_data, [
                    'users_id' => $users->id,
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
            $return['result'] = false;
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

        if (count($mms_attendances) == 0) {
            return ['result' => false, 'messages' => 'No Data Found!', 'data' => []];
        }

        foreach ($mms_attendances as $mss_key => $mms_value) {
            foreach ($hris_attendances as $hris_key => $hris_value) {
                if ($mms_value->employee_number == $hris_value->emp_pms_id) {
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
                    array_push($result, array_merge((array) $mms_value, $hris_data));
                }
            }
        }

        return ['result' => true, 'messages' => 'Data Found!', 'data' => $result];
    }

    public function email_sent()
    {
        $attendances = $this->today_mit();
        if ($attendances['result']) {
            Mail::to('markjay.mercado@ph.fujitsu.com')->send(new AttendanceEmail($attendances['data']));
            return "Attendance email sent!";
        } else {
            return "Attendance email not send, No Data Found!";
        }
    }

    public function get_data($from, $to, Request $request)
    {
        //request data validation
        $request->request->add(['date_from' => $from, 'date_to' => $to]);
        $validator = Validator::make($request->all(), [
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => 'invalid-data',
                'level' => Auth::user()->roles->level,
                'message' => 'Invalid data request.',
                'result' => $validator->errors(),
            ]);
        }

        //instance attendance class
        $attendances = new Attendance;
        $attendance_where = [
            'date_from' => $request->date_from,
            'date_to' => $request->date_to
        ];
            
        if (Auth::user()->roles->level === "USER") {
            $attendance_where['condition'] = [['a.users_id', '=', Auth::user()->id]];
            $mms_attendances = $attendances->select_data($attendance_where);
        } else {
            $attendance_where['condition'] = [];
            $mms_attendances = $attendances->select_data($attendance_where);
        }
        
        //if no data
        if (count($mms_attendances) == 0) {
            return response()->json([
                'result' => false,
                'level' => Auth::user()->roles->level,
                'message' => 'No Data found.',
                'data' => []
            ]);
        }

        $attendances_user = $this->_combine_data_to_hris_manpower($mms_attendances);
        return response()->json([
            'result' => true,
            'level' => Auth::user()->roles->level,
            'message' => 'Data found.',
            'data' => $attendances_user
        ]);
    }
    
    private function _combine_data_to_hris_manpower($data)
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
                        'emp_pms_id' => $man_value->emp_pms_id,
                        'position' => $man_value->position,
                        'shuttle_destination' => $man_value->sh_destination,
                        'employment_type' => $man_value->employment_type,
                        'photo' => $man_value->emp_photo
                    ];
                    array_push($result, array_merge((array) $value, $man_data));
                }
            }
        }

        return $result;
    }

    public function validation_leaves(Attendance $attendances)
    {
        $where = ['a.date' => '2019-12-04', 'a.status' => 'PRESENT'];
        $select = ['b.id', 'a.users_id'];

        //getting all present user
        $data_with_user = $attendances->select_with_users_data($select, $where);
        $present_ids = $data_with_user->pluck('id')->toArray();

        //getting filed leave of present user
        $where = [
            ['date_leave', '=', '2019-12-04'],
            ['status', '!=', 3],
        ];
        $leave_users_present = $attendances->retrieve_users_present_leave($where, $present_ids);
        $leave_ids = $leave_users_present->pluck('id')->toArray();
        
        //auto cancelled leave if present
        $cancelled_data = ['status' => 3];
        $return = $attendances->cancelled_leave($leave_ids, $cancelled_data);
        
        return response()->json($return);
    }
}