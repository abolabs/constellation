<?php

use App\Http\Controllers\API\ApplicationAPIController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\PasswordResetAPIController;
use App\Http\Controllers\API\InfraAPIController;
use App\Http\Controllers\API\UserAPIController;

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
    Route::apiResource('environments', EnvironmentAPIController::class, ['names' => 'v1.environments']);
    Route::apiResource('hosting_types', HostingTypeAPIController::class, ['names' => 'v1.hostingTypes']);
    Route::apiResource('hostings', HostingAPIController::class, ['names' => 'v1.hostings']);
    Route::apiResource('teams', TeamAPIController::class, ['names' => 'v1.teams']);
    Route::apiResource('applications', ApplicationAPIController::class, ['names' => 'v1.applications']);
    Route::post('/applications/import', [ApplicationAPIController::class, 'import'], ['names' => 'v1.applications.import']);
    Route::apiResource('services', ServiceAPIController::class, ['names' => 'v1.services']);
    Route::apiResource('service_versions', ServiceVersionAPIController::class, ['names' => 'v1.serviceVersions']);
    Route::apiResource('service_instances', ServiceInstanceAPIController::class, ['names' => 'v1.service_instances']);
    Route::apiResource('service_instance_dependencies', ServiceInstanceDependenciesAPIController::class, ['names' => 'v1.serviceInstanceDependencies']);
    Route::apiResource('roles', RoleAPIController::class, ['names' => 'v1.roles']);
    Route::apiResource('permissions', PermissionAPIController::class, ['names' => 'v1.permissions']);
    Route::apiResource('users', UserAPIController::class, ['names' => 'v1.users']);
    Route::apiResource('audits', AuditAPIController::class, ['names' => 'v1.audits']);

    /**
     * Profile
     */
    Route::put('/profile', [UserAPIController::class, 'profileUpdate'])->name('v1.profile.update');
    Route::get('/user/permissions', [UserAPIController::class, 'getPermissions'])->name('v1.profile.permissions');
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
