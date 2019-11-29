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

Route::get('token', 'ShuttleLocationController@index');

