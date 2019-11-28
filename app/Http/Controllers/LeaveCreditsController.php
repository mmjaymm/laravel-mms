<?php

namespace App\Http\Controllers;

use App\LeaveCredits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class LeaveCreditsController extends Controller
{
  
    public function index()
    {
        $leave_credits = new LeaveCredits();
        return response()->json($leave_credits->retrieve_all());
    }
  
    public function store(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $leave_type_id = $request->leave_type_id;
        $users_id = $request->users_id;
        $data = $request->except('_token');
        $message = [
            'date_from.unique'=> 'You already set leave credits in this user.'
        ];
        $validator = Validator::make($request->all(),[
            'leave_type_id' =>'required',
            'credits' => 'required',
            'users_id' => 'required',
            'date_from' => ['required',
            Rule::unique('leave_credits')->where(function ($query) use ($date_from, $date_to, $leave_type_id,$users_id) {
                return $query->whereBetween('date_from',[$date_from, $date_to])
                             ->where('leave_type_id',$leave_type_id)
                             ->where('users_id', $users_id);
            })],
            'date_to' => 'required',
        ],$message);
        if($validator->fails())
        {
            return response()->json($validator->errors()->all()); 
        }
        else
        { 
            $leave_credits = new LeaveCredits();
            $insert = $leave_credits->insert_leave_credits($data);     
            return response()->json($insert);
        } 
    }

    public function edit($id)
    {
        $leave_credits = new LeaveCredits();
        return response()->json($leave_credits->retrieve_one($id));  
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
            return response()->json($validator->errors()->all()); 
        }
        else
        {
            $leave_credits = new LeaveCredits();
            $update = $leave_credits->update_leave_credits($data,$id);  
            if($update > 0)
            {
                $return['result'] = True;
                $return['messages'] = "Successfully updated";

            }
            else
            {
                $return['result'] = FALSE;
                $return['messages'] = "Not updated";
            }
            return response()->json($return);


        }
    }

}
