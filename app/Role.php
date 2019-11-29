<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'level'
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}