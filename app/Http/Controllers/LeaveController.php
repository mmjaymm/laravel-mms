<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveCredits;
use App\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;





class LeaveController extends Controller
{
  
    public function index()
    {
      
        $leave = new Leave();
                // $leave->insert_leave($input);
       return $leave->get_leave_credits(5,3);

     
    }

  
    public function create()
    {
        
    }
// request = [date_from,date_to,users_id,leave_type_id,date_filed,is_active]
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
                    $date_insert[] = $date->format('Y-m-d');
                } 
            }
            
            $days_no = count($date_insert);
           
            if($days_no > 0)
            {
                foreach($date_insert as $date_leave)
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
               
                $leave = new Leave();
                $leave_credits = new LeaveCredits();
                $leave->insert_leave($input);
                $leave_data = $leave->get_leave_credits($request->users_id,$request->leave_type_id);
                
                $leave_code = $leave_data->leave_type_code;
                $no_credits = $leave_data->credits;
                $credits_id = $leave_data->credits_id;
                
                if($leave_code == "SL")
                {
                    $credits = (float)$no_credits - (float)$days_no;
                    $credits_data=["credits"=> $credits];
                    return $leave_credits->update_leave_credits($credits_data, $credits_id);
                    
                }
                else
                {
                   
                }
                }

        }
 
    }

    public function show(Leave $leave)
    {

    }


    public function edit(Leave $leave)
    {
     
    }

    public function update(Request $request, Leave $leave)
    {
     
    }


    public function destroy(Leave $leave)
    {
       
    }
}