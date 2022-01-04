<?php

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
// API V1
Route::group(['middleware' => 'api', 'prefix' => 'v1/'], function () {
    Route::resource('environnements', EnvironnementAPIController::class, ['names' => 'v1']);
    Route::resource('hostingTypes', HostingTypeAPIController::class, ['names' => 'v1']);
    Route::resource('hostings', HostingAPIController::class, ['names' => 'v1']);
    Route::resource('teams', TeamAPIController::class, ['names' => 'v1']);
    Route::resource('applications', ApplicationAPIController::class, ['names' => 'v1']);
    Route::resource('services', ServiceAPIController::class, ['names' => 'v1']);
    Route::resource('serviceVersions', ServiceVersionAPIController::class, ['names' => 'v1']);
    Route::resource('service_version_dependencies', ServiceVersionDependenciesAPIController::class, ['names' => 'v1']);
    Route::resource('service_instances', ServiceInstanceAPIController::class, ['names' => 'v1']);
    Route::resource('serviceInstanceDependencies', ServiceInstanceDependenciesAPIController::class, ['names' => 'v1']);
});
