<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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


/**
 * Administration
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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [App\Http\Controllers\InfraController::class, 'index']);

    /**
     * Users & permissions
     */
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    /**
     * Dashboard
     */
    Route::get('/dashboard', [App\Http\Controllers\InfraController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/graphNodes', [App\Http\Controllers\InfraController::class, 'getGraphServicesByApp'])->name('dashboard.graphNodes');

    /**
     * Ressource
     */
    Route::resource('environnements', App\Http\Controllers\EnvironnementController::class);
    Route::resource('hostingTypes', App\Http\Controllers\HostingTypeController::class);
    Route::resource('hostings', App\Http\Controllers\HostingController::class);
    Route::resource('teams', App\Http\Controllers\TeamController::class);
    Route::resource('applications', App\Http\Controllers\ApplicationController::class);
    Route::resource('services', App\Http\Controllers\ServiceController::class);
    Route::resource('serviceVersions', App\Http\Controllers\ServiceVersionController::class);
    Route::resource('serviceVersionDependencies', App\Http\Controllers\ServiceVersionDependenciesController::class);
    Route::resource('appInstances', App\Http\Controllers\AppInstanceController::class);
    Route::resource('appInstanceDependencies', App\Http\Controllers\AppInstanceDependenciesController::class);

});

Route::resource('audits', App\Http\Controllers\AuditController::class);
