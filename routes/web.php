<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\InfraController::class, 'index']);

    /**
     * Localization.
     */
    Route::get('user/lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'index']);

    /**
     * Users & permissions.
     */
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    /**
     * Dashboard.
     */
    Route::get('/dashboard', [App\Http\Controllers\InfraController::class, 'index'])->name('dashboard.index');

    /**
     * Application Mapping.
     */
    Route::get('/applicationMapping/AppMap', [App\Http\Controllers\InfraController::class, 'displayAppMap'])->name('applicationMapping.AppMap');
    Route::get('/applicationMapping/byApp', [App\Http\Controllers\InfraController::class, 'displayByApp'])->name('applicationMapping.byApp');
    Route::get('/applicationMapping/byHosting', [App\Http\Controllers\InfraController::class, 'displayByHosting'])->name('applicationMapping.byHosting');
    Route::get('/applicationMapping/graphNodesByApp', [App\Http\Controllers\InfraController::class, 'getGraphServicesByApp'])->name('applicationMapping.graphNodesByApp');
    Route::get('/applicationMapping/graphNodesByHosting', [App\Http\Controllers\InfraController::class, 'getGraphServicesByHosting'])->name('applicationMapping.graphNodesByHosting');
    Route::get('/applicationMapping/graphNodesAppMap', [App\Http\Controllers\InfraController::class, 'getGraphByApp'])->name('applicationMapping.getGraphByApp');

    /**
     * User setting.
     */
    Route::get('user/setting', [UserController::class, 'settings'])->name('user.settings');
    Route::patch('user/setting', [UserController::class, 'storeSettings'])->name('user.updateSettings');

    /**
     * Ressource.
     */
    Route::resource('environnements', App\Http\Controllers\EnvironnementController::class);
    Route::resource('hostingTypes', App\Http\Controllers\HostingTypeController::class);
    Route::resource('hostings', App\Http\Controllers\HostingController::class);
    Route::resource('teams', App\Http\Controllers\TeamController::class);
    Route::resource('applications', App\Http\Controllers\ApplicationController::class);
    Route::resource('services', App\Http\Controllers\ServiceController::class);
    Route::resource('serviceVersions', App\Http\Controllers\ServiceVersionController::class);
    Route::resource('serviceVersionDependencies', App\Http\Controllers\ServiceVersionDependenciesController::class);
    Route::resource('serviceInstances', App\Http\Controllers\ServiceInstanceController::class);
    Route::resource('serviceInstanceDependencies', App\Http\Controllers\ServiceInstanceDependenciesController::class);
    Route::resource('audits', App\Http\Controllers\AuditController::class);

    /**
     * Administration.
     */
    Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
    Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');
    Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');
    Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');
    Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');
    Route::post(
        'generator_builder/generate-from-file',
        '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
    )->name('io_generator_builder_generate_from_file');
});

// API Route used for the front
Route::group(['middleware' => 'auth', 'prefix' => 'api'], function () {
    Route::resource('environnements', App\Http\Controllers\API\EnvironnementAPIController::class, ['names' => 'api.web.environnements']);
    Route::resource('hostingTypes', App\Http\Controllers\API\HostingTypeAPIController::class, ['names' => 'api.web.hostingTypes']);
    Route::resource('hostings', App\Http\Controllers\API\HostingAPIController::class, ['names' => 'api.web.hostings']);
    Route::resource('teams', App\Http\Controllers\API\TeamAPIController::class, ['names' => 'api.web.teams']);
    Route::resource('applications', App\Http\Controllers\API\ApplicationAPIController::class, ['names' => 'api.web.applications']);
    Route::resource('services', App\Http\Controllers\API\ServiceAPIController::class, ['names' => 'api.web.services']);
    Route::resource('serviceVersions', App\Http\Controllers\API\ServiceVersionAPIController::class, ['names' => 'api.web.serviceVersions']);
    Route::resource('service_version_dependencies', App\Http\Controllers\API\ServiceVersionDependenciesAPIController::class, ['names' => 'api.web.service_version_dependencies']);
    Route::resource('service_instances', App\Http\Controllers\API\ServiceInstanceAPIController::class, ['names' => 'api.web.service_instances']);
    Route::resource('serviceInstanceDependencies', App\Http\Controllers\API\ServiceInstanceDependenciesAPIController::class, ['names' => 'api.web.serviceInstanceDependencies']);
});
