<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Undertime extends Model
{

    protected $fillable = ['datetime_out','reason','attendances_id','users_id'];
    protected $guarded  = ['id'];

    public function insert_undertime_data($data)
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

    public function select_data($where)
    {
        $undertimes = DB::connection('pgsql')
                    ->table('undertimes')
                    ->select('*');
         

        if ($where['is_deleted'] === 1) {
            $undertimes->where('is_deleted', 1);
        }
        
        if ($where['is_deleted'] === 0) {
            $undertimes->where('is_deleted', 0);
        }

        if ($where['is_deleted'] === 'x') {
            
            $undertimes->whereIn('is_deleted',[0,1]);
        }
    
                
        return $undertimes->get();
    }



       
}
