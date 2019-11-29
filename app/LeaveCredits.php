<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class LeaveCredits extends Model
{
    protected $fillable=['leave_type_id','credits','users_id','date_from','date_to'];
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
        return LeaveCredits::all();
    }

    public function retrieve_one($where = [0])
    {
        return DB::table('leave_credits as a')
        ->leftjoin('users as b','b.id','=','a.users_id')
        ->leftjoin('leave_types as c','c.id','=','a.leave_type_id')
        ->select('a.*','b.employee_number','c.leave_type','c.leave_type_code')
        ->where($where)
        ->first();
    }

    public function retrieve($where = [0])
    {
        return DB::table('leave_credits as a')
        ->leftjoin('users as b','b.id','=','a.users_id')
        ->leftjoin('leave_types as c','c.id','=','a.leave_type_id')
        ->select('a.*','b.employee_number','c.leave_type','c.leave_type_code')
        ->where($where)
        ->get();

    }




 
}
