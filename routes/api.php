<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TenderBidController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::prefix('auth')->group(function () {

    Route::post('/login-email', [AuthController::class, 'loginByEmail']);
    Route::post('/login-phone/code', [AuthController::class, 'loginByPhoneSendCode']);
    Route::post('/login-phone/confirm', [AuthController::class, 'loginByPhoneConfirmCode']);

    Route::post('/register/code', [AuthController::class, 'registerSendCode']);
    Route::post('/register/confirm', [AuthController::class, 'registerConfirmCode']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
    });

});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}/show', [UserController::class, 'show']);
        Route::post('/{user}/update', [UserController::class, 'update']);
        Route::delete('/{user}/delete', [UserController::class, 'delete']);

        Route::get('/{user}/companies', [UserController::class, 'getCompanies']);
        Route::get('/{user}/tenders', [UserController::class, 'getTenders']);
        Route::get('/{user}/bids', [UserController::class, 'getBids']);
    });

    // Company routes
    Route::prefix('companies')->group(function () {

        Route::get('/', [CompanyController::class, 'index']);
        Route::post('/create', [CompanyController::class, 'store']);

        Route::get('/{company}/show', [CompanyController::class, 'show']);
        Route::post('/{company}/verify', [CompanyController::class, 'verify']);
        Route::delete('/{company}/delete', [CompanyController::class, 'delete']);

    });

    // Tender routes
    Route::prefix('tenders')->group(function () {

        // Tenders
        Route::get('/', [TenderController::class, 'index']);
        Route::post('/create', [TenderController::class, 'store']);

        Route::get('/{tender}/show', [TenderController::class, 'show']);
        Route::post('/{tender}/update', [TenderController::class, 'update']);
        Route::post('/{tender}/change-status', [TenderController::class, 'changeStatus']);
        Route::delete('/{tender}/delete', [TenderController::class, 'delete']);

        // Bids
//        Route::get('/{tender}/bids/get', [TenderBidController::class, 'index']);
//        Route::post('/{tender}/bids/create', [TenderBidController::class, 'store']);
//        Route::get('/{tender}/bids/{bid}/show', [TenderBidController::class, 'show']);
//        Route::post('/{tender}/bids/{bid}/update', [TenderBidController::class, 'update']);
//        Route::delete('/{tender}/bids/{bid}/delete', [TenderBidController::class, 'delete']);

    });

});

