<?php

namespace App\Http\Controllers;

use App\LeaveCredits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LeaveCreditsController extends Controller
{
  
    public function index()
    {
        
    }


    public function create()
    {
    
    }

  
    public function store(Request $request)
    {
        $data = $request->except('_token');
       
        $leave_credits = new LeaveCredits();
        return $leave_credits->insert_leave_credits($data);   
    }


    public function show(LeaveCredits $leaveCredits)
    {
        
    }

    public function edit(LeaveCredits $leaveCredits)
    {
        
    }

 
    public function update(Request $request, LeaveCredits $leaveCredits)
    {
        
    }

 
    public function destroy(LeaveCredits $leaveCredits)
    {
    
    }
}
