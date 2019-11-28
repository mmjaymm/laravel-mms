<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Late extends Model
{
    protected $fillable = ['datetime_in', 'reason', 'attendances_id', 'users_id'];

    public function insert_data($data)
    {
        return Late::create($data)->save();
    }

    public function update_data($id, $data)
    {
        return Late::where('id', $id)->update($data);
    }

    public function edit_data($id)
    {
        return Late::where('id', $id)->get();
    }

    public function select_data($where)
    {
        $late = DB::table('lates')->select('*');

        if ($where['is_deleted'] === 1) {
            $late->whereBetween('datetime_in', [$where['date_from'].' 00:00:00', $where['date_to'].' 23:59:59'])
                ->where('is_deleted', 1);
        }
        
        if ($where['is_deleted'] === 0) {
            $late->whereBetween('datetime_in', [$where['date_from'].' 00:00:00', $where['date_to'].' 23:59:59'])
            ->where('is_deleted', 0);
        }

        if ($where['is_deleted'] === 'x') {
            $late->whereBetween('datetime_in', [$where['date_from'].' 00:00:00', $where['date_to'].' 23:59:59']);
        }

        return $late->get();
    }

    // public function attendance()
    // {
    //     return $this->hasOne('App\Attendance','status_id');
    // }
}