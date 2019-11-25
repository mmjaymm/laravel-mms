<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Late extends Model
{
    protected $fillable = ['datetime_in', 'reason'];

    public function insert_data($data)
    {
        return Late::create($data)->id;
    }

    public function update_data($id, $where)
    {
        return Late::where('id', $id)->update($data);
    }

    public function edit_data($id)
    {
        return Late::where('id', $id)->get();
    }

    public function select_data()
    {
        return DB::table('lates')
            ->select('*')
            ->where($where)
            ->get();
    }
}