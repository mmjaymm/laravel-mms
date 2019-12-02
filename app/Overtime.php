<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function select_data($where)
    {
        return Overtime::where($where)->get();
    }
}