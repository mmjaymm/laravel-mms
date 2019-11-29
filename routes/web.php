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

Route::get('mms-login','PageController@view_login');
Route::get('home','PageController@view_home');
Route::get('list-filed-late','PageController@view_list_filed_late');
Route::get('list-filed-undertime','PageController@view_list_filed_undertime');
Route::get('undertime-form','PageController@view_undertime_form');
Route::get('list-filed-leave','PageController@view_list_filed_leave');
Route::get('leave-form','PageController@view_leave_form');


//failure login section
Route::post('failure','FailureController@failure_insert');
Route::get('failure-attendance','FailureController@failure_login_data');
Route::put('update-attendance','FailureController@update_attendance');

//undertime section
Route::post('undertime','UndertimeController@insert_undertime');
Route::get('undertime-details','UndertimeController@get_undertime_data');

Route::get('token','FailureController@index');

Route::resource('leave-credits','LeaveCreditsController');
Route::resource('leave-types','LeaveTypesController');

Route::resource('lates', 'LateController');
Route::get('token', 'LateController@index');
Route::get('attendances', 'AttendanceController@index');
Route::post('attendances/insert', 'AttendanceController@store');

