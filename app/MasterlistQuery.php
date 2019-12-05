<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class MasterlistQuery extends Model
{
    
    public function retrieve_masterlist_hr()
    {
        return DB::connection('mysql')
                ->table('hris.hrms_emp_masterlist')
                ->where('emp_system_status','ACTIVE')
                ->where('section_code','MIT')
                ->select('emp_pms_id','emp_last_name','emp_first_name')
                ->get();
    }

    public function retrieve_masterlist_users()
    {

        return DB::connection('pgsql')
                ->table('users')
                ->select('employee_number')
                ->get();
    }
}
