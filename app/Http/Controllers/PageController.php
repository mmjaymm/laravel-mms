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

// --------------------- LATE Module ----------------
    public function view_list_filed_late()
    {
        return view('pages.attendance.late.list_of_filed_late');
    }


// --------------------- Undertime Module ------------
    public function view_list_filed_undertime()
    {
        return view('pages.attendance.undertime.list_of_filed_undertime');
    }
    public function view_undertime_form()
    {
        return view('pages.attendance.undertime.undertime_form');
    }

// --------------------- Leace Module ------------
    public function view_list_filed_leave()
    {
        return view('pages.attendance.undertime.list_of_filed_leave');
    }
    public function view_leave_form()
    {
        return view('pages.attendance.leave.leave_form');
    }
}
