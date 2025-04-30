<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('campaigns', CampaignController::class);
Route::apiResource('donations', DonationController::class);
Route::apiResource('groups', GroupController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.get');

Route::group(['prefix' => 'auth'], function () {
    Route::middleware('guest')->group(function () {        
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/email/verify', [VerificationController::class, 'verify']);
    Route::post('/email/resend', [VerificationController::class, 'resend']);

    Route::group(['middleware' => 'auth:sanctum', 'verified'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});