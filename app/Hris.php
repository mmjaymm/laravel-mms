<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Hris extends Model
{
    protected $connection = 'hris';

    public function man_power($where)
    {
        return DB::connection('hris')
        ->table('hris.hrms_emp_masterlist')
        ->select('*')
        ->where($where)->get();
    }
}