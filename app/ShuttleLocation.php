<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class ShuttleLocation extends Model
{

    protected $fillable = ['shuttle_location'];
    protected $guarded      = ['id'];
    
    public function insert_shuttle_location($shuttle_data)
    {
      
        return DB::connection('pgsql')
                    ->table('shuttle_locations')
                    ->insert([
                        'shuttle_location'   =>$shuttle_data['shuttle_location'],
                        'created_at'         =>Carbon::now(),   
                        'updated_at'         =>Carbon::now()   
                    ]);

    }

    public function load_shuttle_location()
    {


    }

    public function update_shuttle_location()
    {


    }
}
