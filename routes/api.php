<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Models\Servicio;
use App\Http\Controllers\Auth\ExternalLoginController;
use App\Http\Controllers\EspecialistaController;
use App\Http\Controllers\TipoServicioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'servicios'],function () {
    Route::get('/', [ServicioController::class, 'index']);
    Route::post('/store', [ServicioController::class, 'store']);
});

Route::get('/tipos-servicios', [TipoServicioController::class, 'index'])->name('tipos.servicios');
Route::post('/verify-login', [ExternalLoginController::class, 'verify']);
Route::post('/register-especialista', [EspecialistaController::class, 'store'])->name('store.especialista');