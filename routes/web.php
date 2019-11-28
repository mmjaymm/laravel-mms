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

//undertime section
Route::post('undertime/insert','UndertimeController@store');
Route::put('undertime/{id}','UndertimeController@edit');
Route::put('undertime/{id}','UndertimeController@update');


Route::get('token','FailureController@index');
