<?php

namespace App\Http\Controllers;

use App\LeaveTypes;
use Illuminate\Http\Request;

class LeaveTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
       
        $leave_types = new LeaveTypes();
        return $leave_types->insert_leave_type($data);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveTypes $leaveTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveTypes $leaveTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        $leave_types = new LeaveTypes();
        return $leave_types->update_leave_type($data,$id);
       
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveTypes $leaveTypes)
    {
        //
    }
}
