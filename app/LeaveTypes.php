<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveTypes extends Model
{
    protected $fillable = ['leave_type', 'leave_type_code', 'is_active'];
    protected $guard = ['id'];
    
    public function insert_leave_type($data)
    {
        return LeaveTypes::create($data);
    }

    public function update_leave_type($data,$id)
    {
        $leave_types = LeaveTypes::where('id',$id)
                                ->update($data);
        return $leave_types;
    }

    public function retrieve_one($id)
    {
        return LeaveTypes::where('id',$id)->first();

    }

    

  

}
