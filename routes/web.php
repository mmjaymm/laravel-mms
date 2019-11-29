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
Route::post('undertimes/insert','UndertimeController@store');
Route::get('undertimes/{id}/edit','UndertimeController@edit');
Route::patch('undertimes/{id}','UndertimeController@update');
Route::delete('undertimes/{id}', 'UndertimeController@destroy');
Route::post('undertimes/all', 'UndertimeController@retrieve');
Route::post('undertimes/deleted', 'UndertimeController@retrieve');
Route::post('undertimes/not-deleted', 'UndertimeController@retrieve');


Route::get('token','FailureController@index');
