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
                    ->leftJoin('users as c', 'c.id', '=', 'a.reviewer_1')
                    ->leftJoin('users as d', 'd.id', '=', 'a.reviewer_2')
                    ->leftJoin('users as e', 'e.id', '=', 'a.reviewer_3')
                    ->leftJoin('users as f', 'f.id', '=', 'a.reviewer_4')
                    ->select(
                        'a.*',
                        'b.employee_number',
                        'c.employee_number as reviewer_id1',
                        'd.employee_number as reviewer_id2',
                        'e.employee_number as reviewer_id3',
                        'f.employee_number as reviewer_id4'
                    )
                    ->whereBetween('a.datetime_out', [$where['date_from'], $where['date_to']]);
        
        if (count($where['condition']) > 0) {
            $query->where($where['condition']);
        }
        
        return $query->get();
    }

    public function cancelled($id, $data)
    {
        $query = Overtime::where('id', $id)->whereNotIn('ot_status', [1,2,3])
            ->update($data);
        return $query;
    }

    public function getOtStatustAttribute($attribute)
    {
        return [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Declined',
            3 => 'Cancelled'
        ][$attribute];
    }
}