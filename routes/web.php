<?php

use App\Http\Controllers\RolePermissionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/especialistas', function () {
        return Inertia::render('Especialistas/especialistas');
    })->name('especialistas');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
    Route::get('/get-roles-permissions', [RolePermissionController::class, 'rolesypermisos'])->name('get.roles.permissions');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [RolePermissionController::class, 'deleteRole'])->name('roles.delete');
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [RolePermissionController::class, 'deletePermission'])->name('permissions.delete');
});