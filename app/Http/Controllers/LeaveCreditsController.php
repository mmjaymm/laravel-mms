<?php

namespace App\Http\Controllers;

use App\LeaveCredits;
use Illuminate\Http\Request;

class LeaveCreditsController extends Controller
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
        $data = $request->except('_token');
       
        $leave_credits = new LeaveCredits();
        return $leave_credits->insert_leave_credits($data);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LeaveCredits  $leaveCredits
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveCredits $leaveCredits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LeaveCredits  $leaveCredits
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveCredits $leaveCredits)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeaveCredits  $leaveCredits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveCredits $leaveCredits)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeaveCredits  $leaveCredits
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveCredits $leaveCredits)
    {
        //
    }
}
