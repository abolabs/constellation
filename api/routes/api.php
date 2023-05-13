<?php

use App\Http\Controllers\API\Auth\PasswordResetAPIController;
use App\Http\Controllers\API\InfraAPIController;
use App\Http\Controllers\API\UserAPIController;
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
Route::group([
    'middleware' => ['api', 'auth'],
    'prefix' => 'v1/',
], function () {
    /**
     * Application Mapping.
     */
    Route::get('/application-mapping/dashboard', [InfraAPIController::class, 'index'])->name('v1.application-mapping.dashboard');
    Route::get('/application-mapping/app-map', [InfraAPIController::class, 'displayAppMap'])->name('v1.application-mapping.AppMap');
    Route::get('/application-mapping/by-app', [InfraAPIController::class, 'displayByApp'])->name('v1.application-mapping.byApp');
    Route::get('/application-mapping/by-hosting', [InfraAPIController::class, 'displayByHosting'])->name('v1.application-mapping.byHosting');
    Route::get('/application-mapping/graph-nodes-by-app', [InfraAPIController::class, 'getGraphServicesByApp'])->name('v1.application-mapping.graphNodesByApp');
    Route::get('/application-mapping/graph-nodes-by-hosting', [InfraAPIController::class, 'getGraphServicesByHosting'])->name('v1.application-mapping.graphNodesByHosting');
    Route::get('/application-mapping/graph-nodes-app-map', [InfraAPIController::class, 'getGraphByApp'])->name('v1.application-mapping.getGraphByApp');

    /**
     * Resources
     */
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
    Route::resource('permissions', PermissionAPIController::class, ['names' => 'v1.permissions']);
    Route::resource('users', UserAPIController::class, ['names' => 'v1.users']);
    Route::resource('audits', AuditAPIController::class, ['names' => 'v1.audits']);

    /**
     * Profile
     */
    Route::put('/profile', [UserAPIController::class, 'profileUpdate'])->name('v1.profile.update');
});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'v1/',
], function () {
    /**
     * Password reset
     */
    Route::post('/password-reset/send-link', [PasswordResetAPIController::class, 'sendResetLink'])->name('v1.password-reset.send-link');
    Route::post('/password-reset', [PasswordResetAPIController::class, 'resetPassword'])->name('v1.password-reset.reset-password');
});
