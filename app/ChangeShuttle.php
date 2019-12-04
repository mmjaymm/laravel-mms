<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChangeShuttle extends Model
{

    protected $fillable = ['users_id','date_schedule','shuttle_status','shuttle_location_id'];
    protected $guarded  = ['id','control_number'];

    public function retrieve_control()
    {
        return DB::connection('pgsql')
                ->table('change_shuttles')
                ->select('control_number')
                ->where('id', \DB::raw("(select max(id) from change_shuttles)"))
                ->get()
                ->first();

    }

    public function insert_data($data)
    {
        

        $exists = DB::connection('pgsql')->table('change_shuttles')->where('control_number', $data['control_number'])->first();

        if(!$exists)
        {
            DB::connection('pgsql')
                    ->table('change_shuttles')
                    ->insert($data);

            return true;        
        }
        else
        {

            return false;
        }
        
    }
    public function edit_data($id, $data)
   
    {
        return DB::connection('pgsql')
                    ->table('change_shuttles')
                    ->where('id', $id)->update($data);
    }


    public function update_data($id, $data)
    {
        return DB::connection('pgsql')
                    ->table('change_shuttles')
                    ->where('id', $id)
                    ->update([
                        'datetime_schedule' =>$data['datetime_schedule'],
                        'reason'            =>$data['reason'],
                        'shuttle_status'    =>$data['shuttle_status']
                    ]);
    }


    public function select_shuttles_today()
    {
        $todayshuttles = DB::connection('pgsql')
                            ->table('users as a')
                            ->join('shuttle_locations as b','a.shuttle_locations_id','=','b.id')
                            ->join('attendances as c','a.id', '=', 'c.users_id')
                            ->where('.date', date('Y-m-d'))
                            ->select('*');

       
        return $todayshuttles->get();
    }

    public function select_data($where)
    {
        $change = DB::connection('pgsql')
                    ->table('users as a')
                    ->join('change_shuttles as b','a.id', '=', 'b.users_id')
                    ->join('shuttle_locations as c','b.shuttle_location_id','=','c.id')
                    ->select('*');

        
        if ($where['is_deleted'] === 0) 
        {
            $change->where(\DB::raw('substr(cast(b.datetime_schedule as varchar), 0, 10)'), '=',$where['date_search'])
                   ->where('shuttle_location',$where['location'])
                   ->where('b.is_deleted', 0);
        }

        if ($where['is_deleted'] === 'x') 
        {
            $change->where(\DB::raw('substr(cast(b.datetime_schedule as varchar), 0, 10)'), '=',$where['date_search'])
                   ->where('shuttle_location',$where['location']);
        }

        return $change->get();
    }

}
