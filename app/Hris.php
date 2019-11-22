<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Hris extends Model
{
    protected $connection = 'mysql';

    public function man_power($where)
    {
        return DB::connection('mysql')
        ->table('hris.hrms_emp_masterlist')
        ->select('*')
        ->where($where)->get();
    }
}