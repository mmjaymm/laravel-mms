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
Route::post('failure/insert','FailureController@create');
Route::get('failure/{$id}','FailureController@edit');
Route::put('failure/{$id}','FailureController@update');
Route::put('failure/{$id}','FailureController@delete');


Route::get('token','FailureController@index');
