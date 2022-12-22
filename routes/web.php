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

Route::post('/test/upload', [App\Http\Controllers\HomeController::class, 'upload'])->name('test.upload');

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

    /*ACTIVIDADES*/
    Route::get('/actividades', [App\Http\Controllers\ActivityController::class, 'inicio']);
    Route::get('/actividades/all/get', [App\Http\Controllers\ActivityController::class, 'loadAllActivities']);
    Route::get('/actividades/get', [App\Http\Controllers\ActivityController::class, 'get']);
    Route::post('/actividades/store', [App\Http\Controllers\ActivityController::class, 'store']);
    Route::put('/actividades/update', [App\Http\Controllers\ActivityController::class, 'update']);
    //Route::put('/actividades/active', [App\Http\Controllers\ActivityController::class, 'active']);
    //Route::put('/actividades/inactive', [App\Http\Controllers\ActivityController::class, 'inactive']);

    /*DIRECTORIO*/
    Route::get('/directorio', [App\Http\Controllers\DirectoryController::class, 'inicio']);

    Route::get('/directorio/get', [App\Http\Controllers\DirectoryController::class, 'get']);

    Route::get('/directorio/get-directories-assign', [App\Http\Controllers\DirectoryController::class, 'getDirectoriesForAssign']);

    Route::get('/directorio/get-directories-agente', [App\Http\Controllers\DirectoryController::class, 'getDirectoriesAgent']);

    Route::get('/asignacion', [App\Http\Controllers\DirectoryController::class, 'asignacion']);
    Route::get('/asignar/{persona_id}', [App\Http\Controllers\DirectoryController::class, 'asignar']);

    Route::put('/asignar/update/asignar-registros', [App\Http\Controllers\DirectoryController::class, 'asignarRegistrosAgente']);
    Route::put('/asignar/update/desasignar-registros', [App\Http\Controllers\DirectoryController::class, 'desasignarRegistrosAgente']);

    Route::put('/asignar/update/asignar-por-registro', [App\Http\Controllers\DirectoryController::class, 'asignarPorRegistroAgente']);
    Route::put('/asignar/update/desasignar-por-registro', [App\Http\Controllers\DirectoryController::class, 'desasignarPorRegistroAgente']);

    //AVANCES
    Route::get('/avance-general', [App\Http\Controllers\ReportsController::class, 'avanceGeneral']);
    Route::get('/avance-personal', [App\Http\Controllers\ReportsController::class, 'avancePersonal']);

    Route::get('/avance-personal/persona/{persona_id}', [App\Http\Controllers\ReportsController::class, 'avancePersonalPersona']);

    Route::get('/avance-personal/visitas', [App\Http\Controllers\ReportsController::class, 'avancePersonalPersonaVisita']);

    Route::get('/descargas', [App\Http\Controllers\HomeController::class, 'descargas']);

    Route::get('/importacion', [App\Http\Controllers\HomeController::class, 'importacion']);

    Route::get('example/users/export/', [App\Http\Controllers\HomeController::class, 'testExport']);

    Route::get('/localidades/all/get', [App\Http\Controllers\DirectoryController::class, 'loadAllLocalidades']);
    Route::get('/asentamientos/all/get', [App\Http\Controllers\DirectoryController::class, 'loadAllAsentamientos']);

    Route::get('directory/export', [App\Http\Controllers\DirectoryController::class, 'directoryExport']);

});#./Middlware AUTH