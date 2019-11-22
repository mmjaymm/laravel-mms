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
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $where = (object) array(
            'start_date' => '2019-11-21',
            'end_date' => '2019-11-21',
            'section' => 'MANUFACTURING INFORMATION TECHNOLOGY'
        );

        $hris_attendances = $this->get_attendances($where);
        $attendances_data = array();

        foreach ($hris_attendances as $key => $employee) {
            $attendance_status = ($employee->emp_pms_id === null)? 'ABSENT' : 'PRESENT';

            array_push($attendances_data, [
                'users_id' => $employee->emp_pms_id,
                'date' => $employee->WORKDATE,
                'status' => $attendance_status,
            ]);
        }
        
        return response()->json($attendances_data);
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