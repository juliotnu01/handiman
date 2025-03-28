<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\Auth\ExternalLoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VerificationIDController;
use App\Http\Controllers\ReviewsUserController;
use App\Http\Controllers\VerificationEmailController;

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


Route::post('/update-avatar', [UsersController::class, 'updateAvatar'])->name('update.avatar');
Route::get('/user-basic-information/{id}', [UsersController::class, 'getUserWithBasicInformation'])->name('user.basic.information');
Route::post('/store-basic-information', [UsersController::class, 'storeBasicInformation'])->name('store.basic.information');
Route::post('/verify-user', [VerificationIDController::class, 'store'])->name('verify.user');
Route::post('/upload-certificates', [UsersController::class, 'storeCertications'])->name('upload.certificates.user');
Route::post('/store-payment-method', [UsersController::class, 'storePaymentMethod'])->name('store.payment.method');
Route::get('/reviews/paginated/{userId}', [ReviewsUserController::class, 'getPaginatedReviewsByUser'])->name('reviews.paginated.user');
Route::post('/verify-login', [ExternalLoginController::class, 'verify']);
Route::post('/register-user', [ExternalLoginController::class, 'register'])->name('register.user');
Route::get('/verify-email/{code}', [VerificationEmailController::class, 'verify'])->name('verify.email');
Route::post('/resend-verification-email', [VerificationEmailController::class, 'resend'])->name('resend.verification.email');