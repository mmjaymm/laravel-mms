<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Hris;
use App\LeaveTypes;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }
    
    /**
     * Display the specified resource.
     * @param  Request input [date_from,date_to,users_id,leave_type_id,date_filed,is_active]
     */
    public function store(Request $request)
    {
        $data = array($request->except('_token'));
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $message = [
            'users_id.unique' => 'You already set a leave on this date.'
        ];


        $validator = Validator::make($request->all(), [
            'date_from' => 'required',
            'date_to' => 'required',
            'users_id' => [
                'required',
                Rule::unique('leaves')->where(function ($query) use ($date_from,$date_to) {
                    return $query->whereBetween('date_leave', [$date_from,$date_to]);
                })
            ],
            'leave_type_id' => 'required',
            'date_filed' => 'required',
        ], $message);
        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            $now = Carbon::now();
            $period = CarbonPeriod::create($date_from, $date_to);
            $date_insert = [];

            foreach ($period as $date) {
                if ($date->format('l') != 'Saturday' && $date->format('l') != 'Sunday') {
                    $date_insert[] = $date->format('Y-m-d'); //pagkuha ng date_leave ng walang weekends
                }
            }

            $code = $this->get_leave_code($request->leave_type_id); //pagkuha ng leave code
            $days_no = count($date_insert); //no. days ng leave
            
           
            if ($days_no > 0) {
                foreach ($date_insert as $date_leave) {
                    if ($code == 'SL' || $code == 'EL') {
                        $attendance = $this->get_attendance_id($request->users_id, $date_leave); //get attendance id
                        // return $attendance;
                        if (is_null($attendance)) {
                            return response()->json(['result' => false, 'message' => 'Unable to get the attendance id.']);
                        // exit;
                        } else {
                            $input[] = [
                            
                            'users_id' => $request->users_id
                            ,'leave_type_id' => $request->leave_type_id
                            ,'date_leave' =>$date_leave
                            ,'date_filed' => $request->date_filed
                            ,'is_active' => $request->is_active
                            ,'attendances_id' => $attendance->id
                            ,'updated_at' => $now
                            ,'created_at' => $now];
                        }

                        
                        // return $input;
                    } else {
                        $input[] = [
                            'users_id' => $request->users_id
                            ,'leave_type_id' => $request->leave_type_id
                            ,'date_leave' =>$date_leave
                            ,'date_filed' => $request->date_filed
                            ,'is_active' => $request->is_active
                            ,'updated_at' => $now
                            ,'created_at' => $now
                        ];
                    }
                }
                $leave = new Leave();
                $insert = $leave->insert_leave($input);
                if ($insert) {
                    return response()->json(['result' => true, 'message' => 'Leave successfully filed. Wait for approval.']);
                } else {
                    return response()->json(['result' => false, 'message' => 'Unable to file Leave.']);
                }
            }
        }
    }

    public function get_leave_code($leave_type_id)
    {
        $leave_types = new LeaveTypes();
        $code = $leave_types->retrieve_one($leave_type_id);
        return $code->leave_type_code;
    }

    public function get_attendance_id($users_id, $date_leave)
    {
        $where = ['users_id' => $users_id, 'date' => $date_leave];
        $attendance = new Attendance();
        $id = $attendance->retrieve_one($where);

        return $id;
    }

    public function get_hris_details()
    {
        $where = ['section' => 'MANUFACTURING INFORMATION TECHNOLOGY'];
        $hris = new Hris();
        return $hris->man_power($where);
    }

    public function load_leave()
    {
        $leave = new Leave();
        // $users_id = Auth::user()->id;
        $where=[];

        $load_user_leave = $leave->retrieve($where);
        $hris_details = $this->get_hris_details();
   

        foreach ($load_user_leave as $load_key => $load_value) {
            foreach ($hris_details as $hris_key => $hris_value) {
                if ($load_value->employee_number == $hris_value->emp_pms_id) {
                    $load_leave[] =[
                        'employee_number' =>$hris_value->emp_pms_id,
                        'last_name' => $hris_value->emp_last_name,
                        'first_name' => $hris_value->emp_first_name,
                        'middle_name' => $hris_value->emp_middle_name,
                        'leave_type'=> $load_value->leave_type,
                        'leave_code'=> $load_value->leave_type_code,
                        'date_leave' => $load_value->date_leave,
                        'date_files' => $load_value->date_filed

                    ];
                }
            }
        }
        return response()->json($load_leave);
    }

    /**
     * @param  Request input [_token, _method, leave_data = array()]
     * @return \Illuminate\Http\Response
     */
    public function cancelled(Request $request, Leave $leave)
    {
        $cancel_ids = [];
        $cancelled_result = 0;

        if (is_array($request->leave_data)) {
            foreach ($request->leave_data as $key => $value) {
                array_push($cancel_ids, $value['id']);
            }

            $cancelled_result = $leave->cancelled($cancel_ids, ['status' => 3]);
        }

        if ($cancelled_result > 0) {
            return response()->json(['result' => true, 'message' => 'Leave Cancelled Successfully.']);
        } else {
            return response()->json(['result' => false, 'message' => 'Unable to cancel leave.']);
        }
    }

    public function get_all_remaining()
    {
        $leave = new Leave();
        $remaining_leave = $leave->get_all_remaining();
        $hris_details = $this->get_hris_details();
   

        foreach ($remaining_leave as $load_key => $load_value) {
            foreach ($hris_details as $hris_key => $hris_value) {
                if ($load_value->employee_number == $hris_value->emp_pms_id) {
                    $load_leave[] =[
                        'employee_number' =>$hris_value->emp_pms_id,
                        'last_name' => $hris_value->emp_last_name,
                        'first_name' => $hris_value->emp_first_name,
                        'middle_name' => $hris_value->emp_middle_name,
                        'leave_code'=> $load_value->leave_type_code,
                        'credits' => $load_value->credits,
                        'leave_count' => $load_value->leave_count,
                        'remaining' => $load_value->remaining_leave

                    ];
                }
            }
        }

        return $load_leave;


    }

    public function get_users_remaining()
    {
        // $users_id = Auth::user()->id;
        $where = (object) array(
            'users_id' => 5,
        );
        $leave = new Leave();
        $remaining_leave = $leave->get_users_remaining($where);
        $hris_details = $this->get_hris_details();
   

        foreach ($remaining_leave as $load_key => $load_value) {
            foreach ($hris_details as $hris_key => $hris_value) {
                if ($load_value->employee_number == $hris_value->emp_pms_id) {
                    $load_leave[] =[
                        'employee_number' =>$hris_value->emp_pms_id,
                        'last_name' => $hris_value->emp_last_name,
                        'first_name' => $hris_value->emp_first_name,
                        'middle_name' => $hris_value->emp_middle_name,
                        'leave_code'=> $load_value->leave_type_code,
                        'credits' => $load_value->credits,
                        'leave_count' => $load_value->leave_count,
                        'remaining' => $load_value->remaining_leave

                    ];
                }
            }
        }

        return $load_leave;

    }
}