<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('home', function () {
    return view('pages.home');
});
Route::resource('leave-credits','LeaveCreditsController');
Route::resource('leave-types','LeaveTypesController');

Route::resource('lates', 'LateController');
Route::get('token', 'LateController@index');

Route::get('attendances/hris_data', 'AttendanceController@show');
Route::post('attendances/insert', 'AttendanceController@store');
Route::get('attendances/today_mit', 'AttendanceController@today_mit');
Route::get('attendances/get_data', 'AttendanceController@get_data');

Route::resource('overtime', 'OvertimeController');