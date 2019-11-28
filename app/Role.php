<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'level'
    ];

    public function user(Type $var = null)
    {
        # code...
    }
}