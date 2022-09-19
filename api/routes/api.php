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
    Route::resource('environnements', EnvironnementAPIController::class, ['names' => 'v1.environnements']);
    Route::resource('hosting_types', HostingTypeAPIController::class, ['names' => 'v1.hostingTypes']);
    Route::resource('hostings', HostingAPIController::class, ['names' => 'v1.hostings']);
    Route::resource('teams', TeamAPIController::class, ['names' => 'v1.teams']);
    Route::resource('applications', ApplicationAPIController::class, ['names' => 'v1.applications']);
    Route::resource('services', ServiceAPIController::class, ['names' => 'v1.services']);
    Route::resource('service_versions', ServiceVersionAPIController::class, ['names' => 'v1.serviceVersions']);
    Route::resource('service_version_dependencies', ServiceVersionDependenciesAPIController::class, ['names' => 'v1.service_version_dependencies']);
    Route::resource('service_instances', ServiceInstanceAPIController::class, ['names' => 'v1.service_instances']);
    Route::resource('service_instance_dependencies', ServiceInstanceDependenciesAPIController::class, ['names' => 'v1.serviceInstanceDependencies']);
    Route::resource('roles', RoleAPIController::class, ['names' => 'v1.roles']);
    Route::resource('users', UserAPIController::class, ['names' => 'v1.users']);
});
