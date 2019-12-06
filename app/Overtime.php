<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Overtime extends Model
{
    protected $table = 'over_times';

    protected $fillable = [
        'users_id', 'overtime_type', 'datetime_in', 'datetime_out', 'filling_type', 'reason'
    ];

    public function insert_data($data)
    {
        return Overtime::create($data)->id;
    }

    public function update_data($id, $data)
    {
        return Overtime::where('id', $id)->update($data);
    }

    public function update_multiple($leave_ids, $updated_data)
    {
        return DB::table('over_times')->whereIn('id', $leave_ids)->update($updated_data);
    }

    public function select_data($where)
    {
        $query = DB::connection('pgsql')
                    ->table('over_times as a')
                    ->leftJoin('users as b', 'b.id', '=', 'a.users_id')
                    ->select('a.*', 'b.employee_number')
                    ->whereBetween('a.datetime_out', [$where['date_from'], $where['date_to']]);
        
        if (count($where['condition']) > 0) {
            $query->where($where['condition']);
        }
        
        return $query->get();
    }

    public function cancelled($id, $data)
    {
        $query = Overtime::where('id', $id)->whereNotIn('ot_status', [1,2,3])->update($data);
        return $query;
    }
}