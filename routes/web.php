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
Route::post('failure/insert','FailureController@create');
Route::put('failure/{$id}','FailureController@edit');
Route::put('failure/{$id}','FailureController@update');
Route::put('failure/{$id}','FailureController@delete');



//undertime section
Route::post('undertime/insert','UndertimeController@store');
Route::put('undertime/{id}','UndertimeController@edit');
Route::put('undertime/{id}','UndertimeController@update');


Route::get('token','FailureController@index');

Route::resource('leave-credits','LeaveCreditsController');
Route::resource('leave-types','LeaveTypesController');

//late section
Route::resource('lates', 'LateController');
Route::get('token', 'LateController@index');

//attendance section
Route::post('attendances/hris_data', 'AttendanceController@show');
Route::post('attendances/insert', 'AttendanceController@store');
Route::get('attendances/today/email_sent', 'AttendanceController@email_sent');
Route::get('attendances/{from}/{to}', 'AttendanceController@get_data');
Route::get('attendances', 'AttendanceController@index');

//shuttle sections
Route::post('shuttle-location','ShuttleLocationController@add_shuttle_location');
Route::get('all-location','ShuttleLocationController@show_shuttle_location');
Route::put('update-location','ShuttleLocationController@edit_shuttle_location');

//overtime section
Route::resource('overtime', 'OvertimeController');


Route::get('attendances/validate-leave', 'AttendanceController@validation_leaves');
