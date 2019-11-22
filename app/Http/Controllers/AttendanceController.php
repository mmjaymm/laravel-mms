<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Hris;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return csrf_token();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request->dt_start_date
     * @param  $request->slc_section
     * @return response TRUE/FALSE
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'txt_start_date' => 'required|date_format:Y/m/d',
            'slc_section' => 'required',
        ]);

        // $attendances = new Attendance;

        // $where = (object) array(
        //     'start_date' => date("Y-m-d", strtotime($request->txt_start_date)),
        //     'end_date' => date("Y-m-d", strtotime($request->txt_start_date)),
        //     'section' => $request->slc_section
        // );

        // $hris_attendances = $this->get_attendances($where);
        // $attendances_data = array();

        // if(count($hris_attendances) > 0)
        // {
        //     foreach ($hris_attendances as $key => $employee) {
        //         $attendance_status = ($employee->WORKDATE === null)? 'ABSENT' : 'PRESENT';

        //         array_push($attendances_data, [
        //             'users_id' => $employee->emp_pms_id,
        //             'date' => date("Y-m-d", strtotime($request->dt_start_date)),
        //             'status' => $attendance_status,
        //             'created_at' => Carbon::now(),
        //             'updated_at'=> Carbon::now(),
        //         ]);
        //     }
            
        //     $result = $attendances->insert_data($attendances_data);
        // }


        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function get_attendances($where) : array
    {
        $hris = new Hris;
        $result = $hris->attendances($where);

        return $result;
    }
}