<?php

use App\Http\Controllers\AboutusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenterGovernorateController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubServiceController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PaymentController;

// web.php أو api.php
Route::get('/governorates/{id}/centers', function ($id) {
    $centers = App\Models\CenterGovernorate::where('governorate_id', $id)->get(['id', 'name']);
    return response()->json($centers);
});


// Auth Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);

//middleware([RoleMiddleware::class . ':user,admin'])->
Route::group([],function () {
    Route::get('/contact-us', [ContactusController::class, 'index']);

    // About us
    Route::get('/about-us', [AboutusController::class, 'index']);
    Route::get('about-us/{id}', [AboutusController::class, 'show']);


// Authenticated Routes
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('update-profile', [AuthController::class, 'updateProfile']);
    Route::put('change-password', [AuthController::class, 'changePassword']);


    // Routes for Services
    Route::get('services', [ServiceController::class, 'index']);
    Route::get('all-services', [ServiceController::class, 'getAllServices']);
    Route::get('services/{id}', [ServiceController::class, 'show']);

    // Routes for SubServices
    Route::get('sub-services/service/{service_id}', [SubServiceController::class, 'index']);
    Route::get('sub-services/{id}', [SubServiceController::class, 'show']);
    Route::post('sub-services/store', [SubServiceController::class, 'store']);
    Route::post('sub-services/update/{id}', [SubServiceController::class, 'update']);

    Route::post('/complaint/store', [ComplaintController::class, 'store']);
    Route::post('/paymob/webhook', [ComplaintController::class, 'handleWebhook'])->name('paymob.webhook');

    Route::post('/document/store', [DocumentController::class, 'store']);

    // Routes for Questions
    Route::get('questions', [QuestionController::class, 'index']);

    Route::get('notifications', [NotificationController::class, 'index']);

    Route::patch('notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    Route::get('/governorates', [GovernorateController::class, 'index']);
    Route::get('/center-governorates', [CenterGovernorateController::class, 'index']);


    
});
//middleware([RoleMiddleware::class . ':admin'])->
// Admin routes
Route::group([],function () {


    Route::post('/about-us', [AboutusController::class, 'store']);
    Route::put('about-us/{id}', [AboutusController::class, 'update']);
    Route::delete('about-us/{id}', [AboutusController::class, 'destroy']);
    
    Route::get('all-users', [AuthController::class, 'allUsers']);

    Route::post('services', [ServiceController::class, 'store']);

    Route::put('services/{id}', [ServiceController::class, 'update']);
    Route::delete('services/{id}', [ServiceController::class, 'destroy']);


    Route::post('sub-services', [SubServiceController::class, 'store']);
    Route::put('sub-services/{id}', [SubServiceController::class, 'update']);
    Route::delete('sub-services/{id}', [SubServiceController::class, 'destroy']);

    Route::post('questions', [QuestionController::class, 'store']);
    Route::put('questions/{id}', [QuestionController::class, 'update']);
    Route::delete('questions/{id}', [QuestionController::class, 'destroy']);

    Route::post('notifications', [NotificationController::class, 'store']);
    Route::put('notifications/{id}', [NotificationController::class, 'update']);
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);

    Route::post('governorates', [GovernorateController::class, 'store']);
    Route::get('governorates/{id}', [GovernorateController::class, 'show']);
    Route::put('governorates/{id}', [GovernorateController::class, 'update']);
    Route::delete('governorates/{id}', [GovernorateController::class, 'destroy']);

    Route::post('center-governorates', [CenterGovernorateController::class, 'store']);
    Route::get('center-governorates/{id}', [CenterGovernorateController::class, 'show']);
    Route::put('center-governorates/{id}', [CenterGovernorateController::class, 'update']);
    Route::delete('center-governorates/{id}', [CenterGovernorateController::class, 'destroy']);
});
    Route::get('delete_account', [AuthController::class, 'delete_account']);
