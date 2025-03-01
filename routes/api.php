<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\Auth\ExternalLoginController;
use App\Http\Controllers\UsersController;
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



Route::post('/verify-user', [VerificationIDController::class, 'store'])->name('verify.user');
Route::post('/upload-certificates', [UsersController::class, 'storeCertications'])->name('upload.certificates.user');
Route::post('/store-payment-method', [UsersController::class, 'storePaymentMethod'])->name('store.payment.method');

Route::post('/verify-login', [ExternalLoginController::class, 'verify']);