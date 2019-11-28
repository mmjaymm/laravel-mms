<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Hris;

class Attendance extends Model
{
    protected $fillable = [
        'users_id', 'date', 'status'
    ];
    
    public function insert_data($datas)
    {
        //return Attendance::insert($datas);
        return Attendance::create($datas);
    }

    public function update_data($id, $data)
    {
        return Attendance::where('id', $id)->update($data);
    }

    public function today($today_date)
    {
        $attendance = DB::connection('pgsql')->table('attendances')
            ->select('*')->where('date', $today_date);

        return $attendance->get();
    }

    public function late()
    {
        return $this->belongsTo('App\Late', 'status_id');
    }

    public function undertime()
    {
        // return $this->belongsTo('App\Late', 'status_id');
    }

    public function select_data($from, $to)
    {
        $attendance = DB::connection('pgsql')->table('attendances')
            ->select('*')->whereBetween('date', [$from , $to]);

        return $attendance->get();
    }
    
    public function select_with_users_data($select, $where)
    {
        return DB::connection('pgsql')->table('attendances as a')
            ->leftJoin('users as b', 'b.employee_number', '=', 'a.users_id')
            ->select($select)
            ->where($where)
            ->get();
    }

    public function retrieve_users_present_leave($user_ids)
    {
        return DB::table('leaves')->whereIn('id', $user_ids)->select('*')->get();
    }

    public function cancelled_leave($leave_ids, $updated_data)
    {
        return DB::table('leaves')->whereIn('id', $leave_ids)->update($updated_data);
    }
}