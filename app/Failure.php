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

    public function insert_data($data)
    {
        return DB::connection('pgsql')->table('failures')->insertGetId($data);
    }

    public function update_data($id, $data)
    {
        return DB::connection('pgsql')->table('failures')->where('id', $id)->update($data);
    }

    public function edit_data($id)
    {
        return Failure::where('id', $id)->get();
    }
}
