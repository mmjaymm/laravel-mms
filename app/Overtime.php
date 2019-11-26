<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{   
    protected $table = 'over_time';

    protected $fillable = [
        'users_id', 'overtime_type', 'datetime_in', 'datetime_out', 'ot_status', 'reason'
    ];

    public function insert_data($data)
    {
        return Overtime::create($data)->save();
    }
}