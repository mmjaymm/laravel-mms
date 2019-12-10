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
        return Attendance::insert($datas);
    }

    public function update_data($id, $data)
    {
        return Attendance::where('id', $id)->update($data);
    }

    public function today($today_date)
    {
        $attendance = DB::connection('pgsql')
            ->table('attendances as a')
            ->leftJoin('users as b', 'b.id', '=', 'a.users_id')
            ->select('a.*', 'b.employee_number')
            ->where('date', $today_date);

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

    public function select_data($where)
    {
        $query = DB::connection('pgsql')
                        ->table('attendances as a')
                        ->leftJoin('users as b', 'b.id', '=', 'a.users_id')
                        ->select('a.*', 'b.employee_number')
                        ->whereBetween('a.date', [$where['date_from'], $where['date_to']]);

        if (count($where['condition']) > 0) {
            $query->where($where['condition']);
        }
        
        return $query->get();
    }
    
    public function select_with_users_data($select, $where)
    {
        return DB::connection('pgsql')->table('attendances as a')
            ->leftJoin('users as b', 'b.id', '=', 'a.users_id')
            ->select($select)
            ->where($where)
            ->get();
    }

    public function retrieve_users_present_leave($where, $user_ids)
    {
        return DB::table('leaves')
            ->where($where)
            ->whereIn('id', $user_ids)->select('*')->get();
    }

    public function cancelled_leave($leave_ids, $updated_data)
    {
        return DB::table('leaves')->whereIn('id', $leave_ids)->update($updated_data);
    }

    public function retrieve_one($where)
    {
        // return DB::connection('pgsql')->table('attendances')
        // ->select($select)
        // ->where($where)
        // ->get();
        
        return Attendance::where($where)
        ->first();
    }
}