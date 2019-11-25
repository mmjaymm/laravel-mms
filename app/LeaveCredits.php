<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveCredits extends Model
{
    protected $fillable=['leave_type_id','credits','users_id'];
    protected $guard = ['id'];

    public function insert_leave_credits($data)
    {
        return LeaveCredits::create($data);
    }

    public function update_leave_credits($data,$id)
    {
        $leave_credits = LeaveCredits::where('id',$id)
                                    ->update($data);
        return $leave_credits;
    }
    public function retrieve_all()
    {
        return LeaveCredits::where('credits','>','0')->get();
    }


 
}
