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
}