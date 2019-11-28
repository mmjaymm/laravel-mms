<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Undertime extends Model
{

    protected $fillable = ['datetime_out','reason','attendances_id','users_id'];
    protected $guarded  = ['id'];

    public function insert_data($data)
    {
        return DB::connection('pgsql')
                ->table('undertimes')
                ->insertGetId($data);
    }

    public function update_data($id, $data)
    {
        return DB::connection('pgsql')
                ->table('undertimes')
                ->where('id', $id)
                ->update($data);
    }

    public function edit_data($id)
    {
        return DB::connection('pgsql')
                ->table('undertimes')
                ->where('id', $id)
                ->get();
    }



       
}
