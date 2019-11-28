<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Failure extends Model
{
    //

    protected $fillable     = ['datetime_in','datetime_out','reason'];
    protected $editfillable = ['date','status'];
    protected $guarded      = ['id'];

    public function insert_data($data)
    {
        return Failure::create($data)->id;
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

    public function update_data($id, $data)
    {
        return Failure::where('id', $id)->update($data);
    }

    public function edit_data($id)
    {
        return Failure::where('id', $id)->get();
    }
}
