<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes([
    'login'    => true,
    'logout'   => true,
    'register' => false,
    'reset'    => false,
    'confirm'  => false,
    'verify'   => false,
]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', function(){
    return view('test');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/passwords/reset', [App\Http\Controllers\HomeController::class,'passwordReset'])->name('password.reset');
    Route::post('/user/passwords/update', [App\Http\Controllers\HomeController::class,'updatePassword'])->name('password.update');

    /*ROLES (TIPOS) DE USUARIOS*/
    Route::get('/roles-usuarios/get/all', [App\Http\Controllers\TypeUserController::class, 'getAll']);

    /*PERSONAL*/
    Route::get('/personal', [App\Http\Controllers\PersonController::class, 'index'])->name('personal');
    Route::get('/personal/get/all/active', [App\Http\Controllers\PersonController::class, 'getAllActive']);
    Route::get('/personal/get', [App\Http\Controllers\PersonController::class, 'get']);
    Route::get('/personal/agentes/get', [App\Http\Controllers\PersonController::class, 'getAgents']);
    Route::post('/personal/store', [App\Http\Controllers\PersonController::class, 'store']);
    Route::put('/personal/update', [App\Http\Controllers\PersonController::class, 'update']);
    Route::put('/personal/active', [App\Http\Controllers\PersonController::class, 'active']);
    Route::put('/personal/inactive', [App\Http\Controllers\PersonController::class, 'inactive']);

    /*DIRECTORIO*/
    Route::get('/directorio', [App\Http\Controllers\DirectoryController::class, 'indexWeb'])->name('index-web');

    Route::get('/directorio/get-directories-assign', [App\Http\Controllers\DirectoryController::class, 'getDirectoriesForAssign']);

    Route::get('/directorio/get-directories-agente', [App\Http\Controllers\DirectoryController::class, 'getDirectoriesAgent']);

    Route::get('/asignacion', [App\Http\Controllers\DirectoryController::class, 'asignacion']);
    Route::get('/asignar/{persona_id}', [App\Http\Controllers\DirectoryController::class, 'asignar']);

    Route::put('/asignar/update/asignar-registros', [App\Http\Controllers\DirectoryController::class, 'asignarRegistrosAgente']);
    Route::put('/asignar/update/desasignar-registros', [App\Http\Controllers\DirectoryController::class, 'desasignarRegistrosAgente']);
});#./Middlware AUTH