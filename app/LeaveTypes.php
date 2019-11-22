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

  

}
