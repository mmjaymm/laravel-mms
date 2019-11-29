<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class ShuttleLocation extends Model
{

    protected $connection = 'mysql';

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


    public function default_location()
    {

        $location = DB::connection('mysql')->table('hris.hrms_emp_masterlist')
                ->where('section_code','MIT')
                ->where('emp_system_status','ACTIVE')
                ->selectRaw('emp_pms_id as employee_number,sh_destination as shuttle_destination');

        return $location->get();
    }



}
