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
        return Overtime::create($data)->save();
    }

    public function update_data($id, $data)
    {
        return Overtime::where('id', $id)->update($data);
    }

    public function select_data($where)
    {
        $query = DB::connection('pgsql')
                    ->table('over_times')
                    ->whereBetween('datetime_out', [$where['date_from'], $where['date_to']]);
        
        if (count($where['condition']) > 0) {
            $query->where($where['condition']);
        }
        
        return $query->get();
    }
}