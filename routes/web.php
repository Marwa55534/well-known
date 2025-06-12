<?php

use App\Http\Controllers\Dashboard\AboutusController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CenterGovernorateController;
use App\Http\Controllers\Dashboard\ContactusController;
use App\Http\Controllers\Dashboard\GovernorateController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\SubServiceController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'loginView'])->name('login-view');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => AdminMiddleware::class], function () {

    
    Route::get('/users', [HomeController::class, 'index'])->name('users');
    Route::get('/', [HomeController::class, 'home'])->name('home');


// Done
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::post('/services', [HomeController::class, 'creatServices'])->name('creat-services');
Route::get('/services/{id}/edit', [HomeController::class, 'editService']);
Route::put('/services/{id}', [HomeController::class, 'updateServices'])->name('update-services');
Route::delete('/services/{service}', [HomeController::class, 'deleteService'])->name('delete-service');

Route::get('/sub-services', [SubServiceController::class, 'index'])->name('sub-services');
Route::delete('/sub-services/{id}', [SubServiceController::class, 'destroy'])->name('delete-sub-services');
Route::post('/sub-services', [SubServiceController::class, 'store'])->name('create-sub-services');
Route::get('/sub-services/{id}/edit', [SubServiceController::class, 'editSubService'])->name('edit-sub-services');

Route::get('/sub-services/{id}/edit-page', [SubServiceController::class, 'editPage'])->name('sub-services.editPage');


Route::put('/sub-services/{id}', [SubServiceController::class, 'updateSubService'])->name('update-sub-services');

Route::get('/governorates', [GovernorateController::class, 'index'])->name('governorates');
Route::post('/governorates', [GovernorateController::class, 'storeGovernate'])->name('create-governate');
Route::delete('/governorate/{id}', [GovernorateController::class, 'deleteGovernate'])->name('delete-governate');
Route::get('/governorate/{id}/edit', [GovernorateController::class, 'editGovernorate'])->name('edit-governorate');
Route::put('/governorate/{id}', [GovernorateController::class, 'updateGovernorates'])->name('update-governorate');


Route::get('/questions', [QuestionController::class, 'index'])->name('questions');
Route::post('/questions', [QuestionController::class, 'store'])->name('create-questions');
Route::get('/questions/{id}/edit', [QuestionController::class, 'editQuestion'])->name('edit-questions');
Route::put('/questions/{id}', [QuestionController::class, 'updateQuestions'])->name('update-questions');
Route::delete('/questions/{id}', [QuestionController::class, 'deleteQuestion'])->name('delete-questions');

Route::get('/center-governate', [CenterGovernorateController::class, 'index'])->name('center-governate');
Route::post('/center-governate', [CenterGovernorateController::class, 'storeCeterGovernate'])->name('create-center-governate');
Route::delete('/center-governate/{id}', [CenterGovernorateController::class, 'deleteCeterGovernate'])->name('delete-center-governate');
Route::get('/center-governate/{id}/edit', [CenterGovernorateController::class, 'editCenterGovernorate'])->name('edit-center-governate');
Route::put('/center-governate/{id}', [CenterGovernorateController::class, 'updateCenterGovernorate'])->name('update-center-governate');


Route::get('/about-us', [AboutusController::class, 'index'])->name('about-us');
Route::post('/about-us', [AboutusController::class, 'store'])->name('create-about-us');

Route::get('/about-us/{id}/edit', [AboutusController::class, 'editAboutUs'])->name('edit-about-us');
Route::put('/about-us/{id}', [AboutusController::class, 'updateAboutUs'])->name('update-about-us');


Route::get('/contact-us', [ContactusController::class, 'index'])->name('contact-us');
Route::post('/contact-us', [ContactusController::class, 'store'])->name('create-contact-us');

Route::get('/contact-us/{id}/edit', [ContactusController::class, 'editContactus'])->name('edit-contact-us');
Route::put('/contact-us/{id}', [ContactusController::class, 'updateContactus'])->name('update-contact-us');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



});
Route::fallback(function () {
    return view('not-found');
});