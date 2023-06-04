<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\NoEncryptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserControllerBcrypt;
use App\Http\Controllers\UserControllerNoEncrypt;
use App\Http\Controllers\NewEncryptionController;
use Illuminate\Http\Request;
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
Route::post('/registration', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/medical_records', [MedicalRecordController::class, 'index']);
    Route::post('/medical_records', [MedicalRecordController::class, 'store']);
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/userNoEncrypt', [UserControllerNoEncrypt::class, 'index']);
    Route::post('/userNoEncrypt', [UserControllerNoEncrypt::class, 'store']);
    Route::get('/newEncrypt', [NewEncryptionController::class, 'index']);
    Route::post('/newEncrypt', [NewEncryptionController::class, 'store']);
});
