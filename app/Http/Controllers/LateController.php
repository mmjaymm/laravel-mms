<?php

namespace App\Http\Controllers;

use App\Late;
use Illuminate\Http\Request;

class LateController extends Controller
{
    public function datas($data)
    {
        return [
            'datetime_in' => $data->datetime_in,
            'reason' => $data->reason
        ];
    }

    public function index()
    {
        return csrf_token();
    }

    public function store(Request $request, Late $late)
    {
        // $result = $late->insert();
        
        $result = $request->all();
        return response()->json($result);
    }
}