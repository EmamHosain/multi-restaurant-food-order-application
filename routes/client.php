<?php
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ClientProfileController;
use Illuminate\Support\Facades\Route;



// auth route 
Route::middleware(['clientAuth'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/update-password', [ClientController::class, 'getUpdatePassword'])->name('update_password');
    Route::post('/logout', [ClientController::class, 'logout'])->name('logout');

    // client profile
    Route::get('/profile', [ClientProfileController::class, 'getProfile'])->name('profile');
    Route::patch('/profile', [ClientProfileController::class, 'profileUpdate'])->name('profile_update');
    Route::get('/update-password', [ClientProfileController::class, 'getUpdatePasswordPage'])->name('update_password_page');
    Route::patch('/update-password', [ClientProfileController::class, 'updatePassword'])->name('password_update');

});



// guest route 
Route::middleware(['clientGuest'])->group(function () {
    Route::get('/login', [ClientController::class, 'clientLogin'])->name('login_page');
    Route::post('/login', [ClientController::class, 'clientLoginSubmit'])->name('login_submit');
    Route::get('/register', [ClientController::class, 'clientRegister'])->name('register_page');
    Route::post('/register', [ClientController::class, 'clientRegisterSubmit'])->name('register_submit');
});
