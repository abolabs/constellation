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

// API Route used for the front
Route::group(['middleware' => 'web'], function () {
    Route::resource('environnements', EnvironnementAPIController::class);
    Route::resource('hostingTypes', HostingTypeAPIController::class);
    Route::resource('hostings', HostingAPIController::class);
    Route::resource('teams', TeamAPIController::class);
    Route::resource('applications', ApplicationAPIController::class);
    Route::resource('services', ServiceAPIController::class);
    Route::resource('serviceVersions', ServiceVersionAPIController::class);
    Route::resource('service_version_dependencies', ServiceVersionDependenciesAPIController::class);
    Route::resource('service_instances', ServiceInstanceAPIController::class);
    Route::resource('serviceInstanceDependencies', ServiceInstanceDependenciesAPIController::class);
});
