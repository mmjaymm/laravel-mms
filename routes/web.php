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
Route::post('failure/insert', 'FailureController@create');
Route::put('failure/{$id}', 'FailureController@edit');
Route::put('failure/{$id}', 'FailureController@update');
Route::put('failure/{$id}', 'FailureController@delete');

//undertime section
Route::post('undertime/insert', 'UndertimeController@store');
Route::put('undertime/{id}', 'UndertimeController@edit');
Route::put('undertime/{id}', 'UndertimeController@update');


Route::get('token', 'FailureController@index');

//leave credits section
Route::get('leave-credits','LeaveCreditsController@index');
Route::post('leave-credits','LeaveCreditsController@store');
Route::patch('leave-credits/{id}','LeaveCreditsController@update');
Route::get('leave-credits/retrieve-user','LeaveCreditsController@retrieve_user');

Route::resource('leave-types','LeaveTypesController');

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

//shuttle swq'update-location', 'ShuttleLocationController@edit_shuttle_location');

//overtime section
Route::resource('overtime', 'OvertimeController');


Route::get('attendances/validate-leave', 'AttendanceController@validation_leaves');

//leave section
Route::get('leave','LeaveController@index');
Route::get('leave-load-leave','LeaveController@load_leave');
Route::post('leave','LeaveController@store');


