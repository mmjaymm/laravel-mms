<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //

    public function view_login()
    {
        return view('login.login');
    }

    public function view_home()
    {
        return view('home');
    }


    public function view_list_filed_late()
    {
        return view('pages.attendance.late.list_of_filed_late');
    }
}
