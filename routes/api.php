<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//FAILURE SECTION
Route::post('failure','FailureController@failure_insert');
Route::put('update-attendance','FailureController@update_attendance');

//UNDERTIME SECTION
Route::post('undertime','UndertimeController@insert_undertime');
Route::get('undertime-details','UndertimeController@get_undertime_data');

//SHUTTLE SECTION
Route::post('shuttle-location','ShuttleLocationController@add_shuttle_location');

