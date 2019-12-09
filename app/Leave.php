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

    public function retrieve($where = [0])
    {
        return DB::table('leaves as a')
                ->leftjoin('users as b', 'b.id', '=', 'a.users_id')
                ->leftjoin('leave_types as c', 'c.id', '=', 'a.leave_type_id')
                ->select('a.*', 'b.employee_number', 'c.leave_type', 'c.leave_type_code')
                ->where($where)
                ->get();
    }

    public function get_all_remaining()
    {
        $load = DB::connection('pgsql')->select("select  a.users_id, c.employee_number, a.leave_type_code,a.credits, COALESCE( b.leave_count, 0 ) as leave_count,COALESCE((a.credits - b.leave_count),a.credits) as remaining_leave
        from

        (select a.*, b.leave_type, b.leave_type_code 
        from leave_credits as a
        left join leave_types as b on a.leave_type_id = b.id)a 

        left join      

        (select count(*) as leave_count,leave_type_id,users_id from leaves group by leave_type_id,users_id) b        
        on a.users_id = b.users_id and a.leave_type_id = b.leave_type_id
        
        left join
	 
	    (select employee_number,id from users)c
	    on a.users_id = c.id");
       

        return $load;
    }

    // public function get_leave_credits($users_id,$leave_type_id)
    // {
    //     return DB::table('leave_types')
    //     ->leftjoin('leave_credits','leave_types.id','=','leave_credits.leave_type_id')
    //     ->where('leave_credits.leave_type_id',$leave_type_id)
    //     ->where('leave_credits.users_id',$users_id)
    //     ->select('leave_credits.users_id','leave_types.id as leave_types_id', 'leave_types.leave_type', 'leave_types.leave_type_code',
    //     'leave_credits.credits','leave_credits.id as credits_id')
    //     ->first();
    // }

    public function cancelled($leave_ids, $updated_data)
    {
        return DB::table('leaves')->whereIn('id', $leave_ids)
            ->where('status', 2)
            ->update($updated_data);
    }

    public function get_users_remaining($where)
    {
        $load = DB::connection('pgsql')->select("select  a.users_id, c.employee_number, a.leave_type_code,a.credits, COALESCE( b.leave_count, 0 ) as leave_count,COALESCE((a.credits - b.leave_count),a.credits) as remaining_leave
        from

        (select a.*, b.leave_type, b.leave_type_code 
        from leave_credits as a
        left join leave_types as b on a.leave_type_id = b.id)a 

        left join      

        (select count(*) as leave_count,leave_type_id,users_id from leaves group by leave_type_id,users_id) b        
        on a.users_id = b.users_id and a.leave_type_id = b.leave_type_id
        
        left join
	 
	    (select employee_number,id from users)c
        on a.users_id = c.id
        where a.users_id = '{$where->users_id}'");

        return $load;
    }
}