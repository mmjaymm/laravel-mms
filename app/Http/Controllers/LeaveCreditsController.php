<?php

namespace App\Http\Controllers;

use App\LeaveCredits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LeaveCreditsController extends Controller
{
  
    public function index()
    {
        $leave_credits = new LeaveCredits();
        return $leave_credits->retrieve_all();
    }


    public function create()
    {
    
    }

  
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($request->all(),[
            'leave_type_id' => 'required',
            'credits' => 'required',
            'users_id' => 'required',
        ]);
        if($validator->fails())
        {
            return $validator->errors()->all(); 
        }
        else
        {
            $leave_credits = new LeaveCredits();
            return $leave_credits->insert_leave_credits($data); 
        } 
    }


    public function show(LeaveCredits $leaveCredits)
    {
        
    }

    public function edit(LeaveCredits $leaveCredits)
    {
        
    }

 
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        $validator = Validator::make($request->all(),[
            'leave_type_id' => 'required',
            'credits' => 'required',
            'users_id' => 'required',
        ]);
        if($validator->fails())
        {
            return $validator->errors()->all(); 
        }
        else
        {
            $leave_credits = new LeaveCredits();
            return $leave_credits->update_leave_credits($data,$id);  
        }
    }

 
    public function destroy(LeaveCredits $leaveCredits)
    {
    
    }
}
