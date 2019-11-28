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
Route::post('failures/insert','FailureController@create');
Route::get('failures/{id}/edit','FailureController@edit');
Route::patch('failures/{id}','FailureController@update');
Route::delete('failures/{id}', 'FailureController@destroy');
Route::post('failures/all', 'FailureController@retrieve');
Route::get('token','FailureController@index');
