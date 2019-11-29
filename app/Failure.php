<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Failure extends Model
{
    //

    protected $fillable     = ['datetime_in','datetime_out','reason','date_file','attendances_id','users_id'];
    protected $guarded      = ['id'];

    public function insert_failure_data($data)
    {
        return DB::connection('pgsql')
                        ->table('failures')
                        ->insertGetId($data);
    }

    public function edit_data($id)
    {
        return DB::connection('pgsql')
                    ->table('failures')
                    ->where('id', $id)->get();
    }

    public function update_data($id, $data)
    {
        return DB::connection('pgsql')
                    ->table('failures')
                    ->where('id', $id)->update($data);
    }

    public function select_data($where)
    {
        $failures = DB::connection('pgsql')
                    ->table('failures')
                    ->where('is_deleted',0)
                    ->select('*');

        return $failures->get();
    }


}
