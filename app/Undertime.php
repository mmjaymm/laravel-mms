<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Undertime extends Model
{

    protected $fillable = ['datetime_out','reason'];
    protected $guarded  = ['id'];

    public function insert_undertime_data($undertime_data)
    {
        

       return DB::connection('pgsql')
                    ->table('undertimes')
                    ->insert([
                        'datetime_out'  => $undertime_data['datetime_out'],
                        'reason'        => $undertime_data['undertime_reason']

                    ]);        
    }

    public function show_undertime_data()
    {

        return DB::connection('pgsql')
                ->table('users')
                ->join('roles', 'users.roles_id', '=', 'roles.id')
                ->join('attendances', 'users.id', '=', 'attendances.users_id')
                ->join('undertimes', 'attendances.status_id', '=', 'undertimes.id')
                ->select('employee_number','date','status','reason','undertimes.created_at')
                ->get();
    }


    public function edit_undertime($undertime_data,$id)
    {

        return DB::connection('pgsql')
                        ->table('undertimes')
                        ->where('id',$id)
                        ->update($undertime_data);

    }

       
}
