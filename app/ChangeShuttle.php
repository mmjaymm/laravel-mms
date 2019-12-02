<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChangeShuttle extends Model
{

    protected $fillable = ['users_id','date_schedule','shuttle_status','shuttle_location_id','control_number'];
    protected $guarded  = ['id'];

    public function retrieve_control()
    {
        return DB::connection('pgsql')
                ->table('change_shuttles')
                ->select('control_number')
                ->where('id', \DB::raw("(select max(id) from change_shuttles)"))
                ->get();

    }

    public function insert_data($data)
    {

        return DB::connection('pgsql')
                    ->table('change_shuttles')
                    ->insert($data);
    }

}
