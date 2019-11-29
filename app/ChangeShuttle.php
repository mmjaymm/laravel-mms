<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeShuttle extends Model
{
    
    protected $fillable = ['','','',''];
    protected $guarded  = ['id'];

    public function insert_data($data)
    {

        return DB::connection('pgsql')
                    ->table('change_shuttles')
                    ->insert($data);
    }

}
