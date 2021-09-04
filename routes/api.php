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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});






Route::resource('environnements', App\Http\Controllers\API\EnvironnementAPIController::class);


Route::resource('hosting_types', App\Http\Controllers\API\HostingTypeAPIController::class);






Route::resource('hostings', App\Http\Controllers\API\HostingAPIController::class);


Route::resource('teams', App\Http\Controllers\API\TeamAPIController::class);




Route::resource('applications', App\Http\Controllers\API\ApplicationAPIController::class);


Route::resource('services', App\Http\Controllers\API\ServiceAPIController::class);


Route::resource('service_versions', App\Http\Controllers\API\ServiceVersionAPIController::class);








Route::resource('service_version_dependencies', App\Http\Controllers\API\ServiceVersionDependenciesAPIController::class);




Route::resource('app_instances', App\Http\Controllers\API\AppInstanceAPIController::class);
