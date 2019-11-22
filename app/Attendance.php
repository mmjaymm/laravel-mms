<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'users_id', 'date', 'status'
    ];

    public function insert_data($datas)
    {
        return Attendance::insert($datas);
    }
}