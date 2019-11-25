<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function today()
    {
        // $attendance = DB::connection('pgsql')->table('attendances')
        //     ->select('*')->where('date', '2019-11-25');


        // return $attendance->get();
        

        return Attendance::with('late')->get();
    }

    public function late()
    {
        return $this->belongsTo('App\Late', 'status_id');
    }

    public function undertime()
    {
        // return $this->belongsTo('App\Late', 'status_id');
    }
}