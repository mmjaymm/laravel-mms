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

Route::get('/', function () {
    return view('welcome');
});

//failure login section
Route::post('failure','FailureController@failure_insert');
Route::get('failure-attendance','FailureController@failure_login_data');
Route::put('update-attendance','FailureController@update_attendance');

//undertime section
Route::post('undertime','UndertimeController@insert_undertime');
Route::get('undertime-details','UndertimeController@get_undertime_data');

Route::get('token','FailureController@index');
