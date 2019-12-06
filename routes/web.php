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

// Route::get('home', function () {
//     return view('home');
// });
// Route::get('mms-login', function () {
//     return view('login.login');
// });

Route::get('mms-login', 'PageController@view_login');
Route::get('home', 'PageController@view_home');
Route::get('list-filed-late', 'PageController@view_list_filed_late');
Route::get('list-filed-undertime', 'PageController@view_list_filed_undertime');
Route::get('undertime-form', 'PageController@view_undertime_form');
Route::get('leave-monitoring-record', 'PageController@view_list_filed_leave');
Route::get('leave-form', 'PageController@view_leave_form');


//failure login section

Route::post('failures/', 'FailureController@create');
Route::get('failures/{id}/edit', 'FailureController@edit');
Route::patch('failures/{id}', 'FailureController@update');
Route::delete('failures/{id}', 'FailureController@destroy');
Route::post('failures/all', 'FailureController@retrieve');
Route::get('token', 'FailureController@index');

//undertime section
Route::post('undertimes/', 'UndertimeController@store');
Route::get('undertimes/{id}/edit', 'UndertimeController@edit');
Route::patch('undertimes/{id}', 'UndertimeController@update');
Route::delete('undertimes/{id}', 'UndertimeController@destroy');
Route::get('undertimes/all', 'UndertimeController@retrieve');
Route::get('undertimes/deleted', 'UndertimeController@retrieve');
Route::get('undertimes/not-deleted', 'UndertimeController@retrieve');


//leave credits section
Route::get('leave-credits', 'LeaveCreditsController@index');
Route::post('leave-credits', 'LeaveCreditsController@store');
Route::patch('leave-credits/{id}', 'LeaveCreditsController@update');
Route::get('leave-credits/retrieve-user', 'LeaveCreditsController@retrieve_user');

Route::resource('leave-types', 'LeaveTypesController');

//late section
Route::post('lates', 'LateController@store');
Route::get('lates/{id}/edit', 'LateController@edit');
Route::put('lates/{id}', 'LateController@update');
Route::delete('lates/{id}', 'LateController@destroy');
Route::post('lates/all', 'LateController@retrieve');
Route::post('lates/deleted', 'LateController@retrieve');
Route::post('lates/not-deleted', 'LateController@retrieve');

//attendance section
Route::post('attendances/hris_data', 'AttendanceController@show');
Route::post('attendances/insert', 'AttendanceController@store');
Route::get('attendances/today/email_sent', 'AttendanceController@email_sent');
Route::get('attendances/{from}/{to}', 'AttendanceController@get_data');
Route::get('attendances', 'AttendanceController@index');

//shuttle swq'update-location', 'ShuttleLocationController@edit_shuttle_location');

//overtime section
Route::post('overtime', 'OvertimeController@index');
Route::post('overtime/store', 'OvertimeController@store');
Route::post('overtime/retrieve', 'OvertimeController@retrieve');
Route::post('overtime/sending_email/{filling_type?}', 'OvertimeController@sending_email'); //filling_type = LATE/ADVANCE
Route::post('overtime/approve', 'OvertimeController@approve');
Route::post('overtime/cancel/{id}', 'OvertimeController@cancel');
Route::post('overtime/cancellation_email', 'OvertimeController@cancellation_email');

//shuttle sections
Route::post('shuttles/', 'ShuttleLocationController@store');
Route::get('shuttles/{id}/edit', 'ShuttleLocationController@edit');
Route::patch('shuttles/{id}', 'ShuttleLocationController@update');
Route::get('shuttles/all', 'ShuttleLocationController@retrieve');
Route::get('shuttles/users', 'ShuttleLocationController@retrieve_default_shuttle');
Route::post('shuttles/all', 'ShuttleLocationController@retrieve');
Route::post('shuttles/users', 'ShuttleLocationController@retrieve_default_shuttle');
Route::post('change/shuttles/insert', 'ChangeShuttleController@store');
Route::post('change/shuttles/display', 'ChangeShuttleController@latest_control_number');
Route::patch('change/shuttles/{id}/update', 'ChangeShuttleController@update');
Route::delete('change/shuttles/{id}', 'ChangeShuttleController@destroy');
Route::post('shuttles/users/today', 'ChangeShuttleController@retrieve_today');
Route::post('change/shuttles/location', 'ChangeShuttleController@retrieve');
Route::post('change/shuttles/all', 'ChangeShuttleController@retrieve');
Route::post('change/shuttles/send', 'ChangeShuttleController@email_changeshuttle');
Route::get('token', 'ShuttleLocationController@index');

Route::get('attendances/validate-leave', 'AttendanceController@validation_leaves');

//login-logout section
Route::post('users/login_auth', 'UserController@login_auth');
Route::get('users/sign_out', 'UserController@sign_out');
Route::get('users/administrator', 'UserController@administrator');
Route::get('users/normal-users', 'UserController@users');
//leave section
Route::get('leave', 'LeaveController@index');
Route::get('leave-load-leave', 'LeaveController@load_leave');
Route::get('leave-attendance', 'LeaveController@get_attendance_id');
Route::post('leave', 'LeaveController@store');
Route::patch('leave/cancel', 'LeaveController@cancelled');
Route::get('leave-get-all-remaining', 'LeaveController@get_all_remaining');
Route::get('leave-get-users-remaining', 'LeaveController@get_users_remaining');