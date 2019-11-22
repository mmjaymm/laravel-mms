<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Hris;
use Illuminate\Http\Request;

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
     * @param  $request->start_date
     * @param  $request->end_date
     * @param  $request->section
     * @return response TRUE/FALSE
     */
    public function store(Request $request)
    {
        $attendances = new Attendance;

        $where = (object) array(
            'start_date' => date("Y-m-d", strtotime($request->start_date)),
            'end_date' => date("Y-m-d", strtotime($request->end_date)),
            'section' => $request->section
        );

        $hris_attendances = $this->get_attendances($where);
        $attendances_data = array();

        foreach ($hris_attendances as $key => $employee) {
            $attendance_status = ($employee->emp_pms_id === null)? 'ABSENT' : 'PRESENT';

            array_push($attendances_data, [
                'users_id' => $employee->emp_pms_id,
                'date' => date("Y/m/d", strtotime($employee->WORKDATE)),
                'status' => $attendance_status,
            ]);
        }
        
        $result = $attendances->insert_data($attendances_data);
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