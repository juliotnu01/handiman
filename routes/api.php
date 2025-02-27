<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Models\Servicio;
use App\Http\Controllers\Auth\ExternalLoginController;
use App\Http\Controllers\EspecialistaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\TipoServicioController;
use App\Http\Controllers\VerificationIDController;

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

Route::group(['prefix' => 'especialistas'],function () {
    Route::get('/', [EspecialistaController::class, 'index'])->name('get.especialistas');
    Route::get('/get-revision-especialista/{id}', [EspecialistaController::class, 'getRevisionEspecialista'])->name('get.revision.especialista');
    Route::put('/update-status-especialista/{id}', [EspecialistaController::class, 'updateStatusEspecialista'])->name('update.status.especialistas');
    Route::put('/update-revision-especialista/{id}', [EspecialistaController::class, 'updateRevisionEspecialista'])->name('update.revision.especialistas');

});

// oferta
Route::group(['prefix' => 'config-especialistas'],function () {
    Route::post('/oferta', [OfertaController::class, 'store'])->name('save.oferta');
});

Route::post('/verify-user', [VerificationIDController::class, 'store'])->name('verify.user');


Route::get('/tipos-servicios', [TipoServicioController::class, 'index'])->name('tipos.servicios');
Route::post('/verify-login', [ExternalLoginController::class, 'verify']);
Route::post('/register-especialista', [EspecialistaController::class, 'store'])->name('store.especialista');