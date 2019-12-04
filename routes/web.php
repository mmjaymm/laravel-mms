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

//shuttle sections
Route::post('shuttles/insert','ShuttleLocationController@store');
Route::get('shuttles/{id}/edit', 'ShuttleLocationController@edit');
Route::patch('shuttles/{id}', 'ShuttleLocationController@update');
Route::post('shuttles/all', 'ShuttleLocationController@retrieve');
Route::post('shuttles/users', 'ShuttleLocationController@retrieve_default_shuttle');
Route::post('change/shuttles/insert','ChangeShuttleController@store');
Route::post('change/shuttles/display','ChangeShuttleController@latest_control_number');
Route::patch('change/shuttles/{id}/update', 'ChangeShuttleController@update');
Route::delete('change/shuttles/{id}', 'ChangeShuttleController@destroy');
Route::post('shuttles/users/today', 'ChangeShuttleController@retrieve_today');
Route::post('change/shuttles/location', 'ChangeShuttleController@retrieve');
Route::post('change/shuttles/all', 'ChangeShuttleController@retrieve');


Route::get('token', 'ShuttleLocationController@index');

