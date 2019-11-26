<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveCredits extends Model
{
    protected $fillable=['leave_type_id','credits','users_id'];
    protected $guard = ['id'];

    public function insert_leave_credits($data)
    {
        return LeaveCredits::create($data);
    }

 
}