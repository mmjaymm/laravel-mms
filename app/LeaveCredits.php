<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveCredits extends Model
{
    public function insert_leave_credits($data)
    {
        return LeaveCredits::create($data);
    }
    //
}
