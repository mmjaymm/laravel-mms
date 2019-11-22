<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Late extends Model
{
    protected $fillable = ['datetime_in', 'reason'];

    public function insert($datas)
    {
        return Late::create($data)->save();
    }
}