<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MasterlistQuery;

class MasterlistQueryController extends Controller
{
    
    protected function index()
    {

        $result = [];

        $data = new MasterlistQuery();
        $result = $data->retrieve_masterlist($data);

        return response()->json($result); 
    }

    public function index2()
    {

        $result = [];

        $data = new MasterlistQuery();
        $result = $data->retrieve_masterlist_users($data);

        //$employee_number = $this->index()->emp_pms_id;

        return response()->json($result); 

    }


}
