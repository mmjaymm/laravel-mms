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

// --------------------- FALIURE Module ----------------
 public function view_list_filed_failure()
 {
     return view('pages.attendance.failure.list_of_filed_failure');
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

// --------------------- Leave Module ------------
    public function view_list_filed_leave()
    {
        return view('pages.attendance.leave.leave_monitoring_record');
    }
    public function view_leave_form()
    {
        return view('pages.attendance.leave.leave_form');
    }
}
