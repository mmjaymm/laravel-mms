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
})->middleware('guest');

//failure login section

Route::post('failures/insert','FailureController@create');
Route::get('failures/{id}/edit','FailureController@edit');
Route::patch('failures/{id}','FailureController@update');
Route::delete('failures/{id}', 'FailureController@destroy');
Route::post('failures/all', 'FailureController@retrieve');
Route::get('token','FailureController@index');

//undertime section
Route::post('undertimes/insert','UndertimeController@store');
Route::get('undertimes/{id}/edit','UndertimeController@edit');
Route::patch('undertimes/{id}','UndertimeController@update');
Route::delete('undertimes/{id}', 'UndertimeController@destroy');
Route::post('undertimes/all', 'UndertimeController@retrieve');
Route::post('undertimes/deleted', 'UndertimeController@retrieve');
Route::post('undertimes/not-deleted', 'UndertimeController@retrieve');
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

//login-logout section
Route::post('users/login_auth', 'UserController@login_auth');
Route::get('users/sign_out', 'UserController@sign_out');
Route::get('users/administrator', 'UserController@administrator');
Route::get('users/normal-users', 'UserController@users');
//leave section
Route::get('leave','LeaveController@index');
Route::get('leave-load-leave','LeaveController@load_leave');
Route::post('leave','LeaveController@store');





