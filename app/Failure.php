<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Failure extends Model
{
    //

    protected $fillable     = ['datetime_in','datetime_out','reason','date_filed'];
    protected $editfillable = ['date','status'];
    protected $guarded      = ['id'];

    public function insert_failure_login($failure_data)
    {


       return DB::connection('pgsql')
                    ->table('failures')
                    ->insert([
                        'datetime_in'   => $failure_data('datetime_in'),
                        'datetime_out'  => $failure_data('datetime_out'),
                        'reason'        => $failure_data('reason'),
                        'date_filed'    => $failure_data('date_filed')
                    ]);        
    }

    public function select_failure_login()
    {

        return DB::connection('pgsql')
                ->table('users')
                ->join('roles', 'users.roles_id', '=', 'roles.id')
                ->join('attendances', 'users.id', '=', 'attendances.users_id')
                ->join('failures', 'attendances.status_id', '=', 'failures.id')
                ->select('employee_number','date','status','datetime_in','datetime_out','reason','date_filed')
                ->get();
    }

    public function edit_attendance_failure($attendance_data,$id)
    {

        return DB::connection('pgsql')
                        ->table('attendances')
                        ->where('id',$id)
                        ->update($attendance_data);

    }
}
