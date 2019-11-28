<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Leave extends Model
{
    
    protected $fillable = ['users_id','leave_type_id','date_leave','status','reviewed_by','reviewed_datetime'
                        ,'date_filed','remarks','is_active'];
    protected $guard = ['id'];

    public function insert_leave($data)
    {
        return Leave::insert($data);
    } 

    public function get_leave_credits($users_id,$leave_type_id)
    {
        return DB::table('leave_types')
        ->leftjoin('leave_credits','leave_types.id','=','leave_credits.leave_type_id')
        ->where('leave_credits.leave_type_id',$leave_type_id)
        ->where('leave_credits.users_id',$users_id)
        ->select('leave_credits.users_id','leave_types.id as leave_types_id', 'leave_types.leave_type', 'leave_types.leave_type_code',
        'leave_credits.credits','leave_credits.id as credits_id')
        ->first();
    }

}