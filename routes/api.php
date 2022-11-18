<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::get('directory','App\Http\Controllers\DirectoryController@index');
Route::get('directory/agent-asignacion','App\Http\Controllers\DirectoryController@getApiDirectoriesAgent');

Route::post('directory/store','App\Http\Controllers\DirectoryController@store');
Route::post('directory/update','App\Http\Controllers\DirectoryController@update');

Route::get('visit/get','App\Http\Controllers\VisitController@index');
Route::post('visit/store','App\Http\Controllers\VisitController@store');

Route::get('activities/get','App\Http\Controllers\ActivityController@index');

Route::get('visit/get/avance','App\Http\Controllers\VisitController@getAvance');



Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', '\App\Http\Controllers\AuthController@login');
    Route::post('signup', '\App\Http\Controllers\AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', '\App\Http\Controllers\AuthController@logout');
        Route::get('user', '\App\Http\Controllers\AuthController@user');
    });
});