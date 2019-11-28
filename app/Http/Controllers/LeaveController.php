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


        $validator = Validator::make($request->all(),[
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
        ],$message);
        if($validator->fails())
        {
            return $validator->errors()->all(); 
        }
        else
        {
            
            $now = Carbon::now();
            $period = CarbonPeriod::create($date_from, $date_to); 
            $date_insert = []; 

            foreach ($period as $date) { 

                if($date->format('l') != 'Saturday' && $date->format('l') != 'Sunday') 
                { 
                    $date_insert[] = $date->format('Y-m-d'); //pagkuha ng date_leave ng walang weekends
                } 
            }

            $code = $this->get_leave_code($request->leave_type_id); //pagkuha ng leave code    
            $days_no = count($date_insert); //no. days ng leave
            
           
            if($days_no > 0)
            {
                foreach($date_insert as $date_leave)
                {
                    if($code == 'SL' || $code == 'EL')
                    {
                        $attendance = $this->get_attendance_id($request->users_id,$date_leave); //get attendance id
                        $input[] = [
                            
                            'users_id' => $request->users_id
                            ,'leave_type_id' => $request->leave_type_id
                            ,'date_leave' =>$date_leave
                            ,'date_filed' => $request->date_filed
                            ,'is_active' => $request->is_active
                            ,'attendances_id' => $attendance->id
                            ,'updated_at' => $now
                            ,'created_at' => $now 
                        ];
                        // return $input;
                       
                    }
                    else
                    {
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
                if($insert)
                {
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

    public function get_attendance_id($users_id,$date_leave)
    {
        // $select = ['id'];
        $where = ['users_id' => $users_id, 'date' => $date_leave];
        $attendance = new Attendance();
        $id = $attendance->get_attendance_id($where);
        return $id;

    }



 
}