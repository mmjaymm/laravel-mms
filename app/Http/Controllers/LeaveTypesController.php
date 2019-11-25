<?php

namespace App\Http\Controllers;

use App\LeaveTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveTypesController extends Controller
{

    public function index()
    {
        return csrf_token();
        $leave_types = new LeaveTypes();
        return $leave_types->retrieve_all(); 

    }

    public function create()
    {
      
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $validator = Validator::make($request->all(),[
            'leave_type' => 'required|unique:leave_types',
            'leave_type_code' => 'required|unique:leave_types',
        ]);
            
        

        if($validator->fails())
        {
            return $validator->errors()->all(); 
        }
        else
        {
            $leave_types = new LeaveTypes();
            return $leave_types->insert_leave_type($data);  
        }
       
 
    }


    public function show(LeaveTypes $leaveTypes)
    {
     
    }

    public function edit($id)
    {
        $leave_types = new LeaveTypes();
        return $leave_types->retrieve_one($id);      
    }

    public function update(Request $request, $id)
    {

        $data = $request->except('_token','_method');
        $validator = Validator::make($request->all(),[
            'leave_type' => 'required',
            'leave_type_code' => 'required',
        ]);
        if($validator->fails())
        {
            return $validator->errors()->all(); 
        }
        else
        {
            $leave_types = new LeaveTypes();
             return $leave_types->update_leave_type($data,$id);  
        }
    }

    public function destroy(LeaveTypes $leaveTypes)
    {
    
    }
}
