<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use Illuminate\Support\Facades\Route;



// auth route
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard_index');
    Route::get('/profile', [AdminProfileController::class, 'getProfile'])->name('profile_index');
    Route::patch('/profile/update', [AdminProfileController::class, 'profileUpdate'])->name('profile_update');
    Route::get('/update-password',[AdminProfileController::class,'getUpdatePasswordPage'])->name('update_password');
    Route::patch('/update-password',[AdminProfileController::class,'getUpdatePasswordSubmit'])->name('update_password_submit');

});



Route::get('/login', [AdminController::class, 'login'])->name('login_create');
Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login_submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AdminController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/forgot-password', [AdminController::class, 'sendEmailForgotPassword'])->name('forgot_password_send_email');
Route::get('/reset-password/{token}', [AdminController::class, 'resetPassword'])->name('reset_password');
Route::post('/reset-password', [AdminController::class, 'resetPasswordSubmit'])->name('reset_password_submit');