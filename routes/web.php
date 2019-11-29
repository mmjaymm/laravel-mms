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
Route::get('mms-login', function () {
    return view('login.login');
});

//failure login section

Route::post('failures/insert','FailureController@create');
Route::get('failures/{id}/edit','FailureController@edit');
Route::patch('failures/{id}','FailureController@update');
Route::delete('failures/{id}', 'FailureController@destroy');
Route::post('failures/all', 'FailureController@retrieve');
Route::get('token','FailureController@index');

//undertime section
Route::post('undertime/insert', 'UndertimeController@store');
Route::put('undertime/{id}', 'UndertimeController@edit');
Route::put('undertime/{id}', 'UndertimeController@update');


Route::get('token', 'FailureController@index');

Route::resource('leave-credits', 'LeaveCreditsController');
Route::resource('leave-types', 'LeaveTypesController');

//late section
Route::post('lates', 'LateController@store');
Route::get('lates/{id}/edit', 'LateController@edit');
Route::put('lates/{id}', 'LateController@update');
Route::delete('lates/{id}', 'LateController@destroy');
Route::post('lates/all', 'LateController@retrieve');
Route::post('lates/deleted', 'LateController@retrieve');
Route::post('lates/not-deleted', 'LateController@retrieve');


Route::get('token', 'LateController@mms_token');

//attendance section
Route::post('attendances/hris_data', 'AttendanceController@show');
Route::post('attendances/insert', 'AttendanceController@store');
Route::get('attendances/today/email_sent', 'AttendanceController@email_sent');
Route::get('attendances/{from}/{to}', 'AttendanceController@get_data');
Route::get('attendances', 'AttendanceController@index');

//shuttle sections
Route::post('shuttle-location', 'ShuttleLocationController@add_shuttle_location');
Route::get('all-location', 'ShuttleLocationController@show_shuttle_location');
Route::put('update-location', 'ShuttleLocationController@edit_shuttle_location');

//overtime section
Route::resource('overtime', 'OvertimeController');


Route::get('attendances/validate-leave', 'AttendanceController@validation_leaves');



