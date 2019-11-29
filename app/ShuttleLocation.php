<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class ShuttleLocation extends Model
{

    protected $fillable = ['shuttle_location'];
    protected $guarded      = ['id'];
    
    public function insert_data($data)
    {
      
        return DB::connection('pgsql')
                    ->table('shuttle_locations')
                    ->insert($data);

    }


    public function edit_data($id)
    {
        return DB::connection('pgsql')
                ->table('shuttle_locations')
                ->where('id', $id)->get();
    }

    public function update_data($id, $data)
    {
        return DB::connection('pgsql')
                ->table('shuttle_locations')
                ->where('id', $id)->update($data);
    }

    public function select_data()
    {
        $location = DB::connection('pgsql')
                    ->table('shuttle_locations')
                    ->where('is_deleted', 0)
                    ->select('*');

        return $location->get();
    }



}
