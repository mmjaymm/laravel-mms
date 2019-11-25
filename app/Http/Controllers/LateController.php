<?php

namespace App\Http\Controllers;

use App\Late;
use Illuminate\Http\Request;
use App\Http\Requests\LatePost;

class LateController extends Controller
{
    private function datas($data)
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

    public function store(LatePost $input_request, Late $lates)
    {
        $return = [];

        if ($input_request->validator->fails()) {
            $return['result'] = FALSE;
            $return['messages'] = $input_request->validator->errors();

            return response()->json($return);
        }


        $result = $late->insert_data($this->datas($input_request));       
        if($result)
        {
            $return['result'] = TRUE;
            $return['messages'] = 'Inserted Successfully.';
        }
        else
        {
            $return['result'] = FALSE;
            $return['messages'] = 'Unable to Insert';
        }
        
        return response()->json($result);
    }
}