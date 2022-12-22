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

Route::get('directory/buscar','App\Http\Controllers\DirectoryController@buscar');

Route::get('directory/resumen-avance-general','App\Http\Controllers\DirectoryController@getApiResumenGeneral');

Route::get('directory/agent-asignacion','App\Http\Controllers\DirectoryController@getApiDirectoriesAgent');
Route::get('directory/agent-resumen-avance','App\Http\Controllers\DirectoryController@getApiResumenAgent');

Route::post('directory/store','App\Http\Controllers\DirectoryController@store');
Route::post('directory/update','App\Http\Controllers\DirectoryController@update');
Route::post('directory/update-image', 'App\Http\Controllers\DirectoryController@uploadDirectoryImage');
Route::post('directory/delete-image', 'App\Http\Controllers\DirectoryController@deleteDirectoryImage');

Route::get('visit/get','App\Http\Controllers\VisitController@index');
Route::post('visit/store','App\Http\Controllers\VisitController@store');

Route::get('activities/get','App\Http\Controllers\ActivityController@index');

Route::get('visit/get/avance','App\Http\Controllers\VisitController@getAvance');

Route::post('visit/upload', 'App\Http\Controllers\VisitController@uploadImage');

Route::get('company/get/info','App\Http\Controllers\CompanyController@getInformation');
Route::get('person/get/info','App\Http\Controllers\PersonController@getPersonaInformation');

Route::get('person/get/agentes','App\Http\Controllers\PersonController@getApiAgentes');
Route::get('person/get/supervisores','App\Http\Controllers\PersonController@getApiSupervisores');

Route::get('person/get/personal-for-messages','App\Http\Controllers\PersonController@getApiPersonalForMessages');

Route::get('conversations/get/supervisor','App\Http\Controllers\ConversationController@getApiConversationsSupervisor');
Route::get('conversations/get/agent','App\Http\Controllers\ConversationController@getApiConversationsAgent');

Route::post('message/store','App\Http\Controllers\MessageController@store');

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