<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
})->name('index');

Route::get('/user/dashboard', function () {
    return view('frontend.dashboard.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // user auth route start here
    Route::patch('/profile/update', [UserController::class, 'profileUpdate'])->name('profile_update');
    Route::get('/update-password', [UserController::class, 'getUpdatePasswordPage'])->name('update_password');
    Route::patch('/update-password', [UserController::class, 'updatePasswordSubmit'])->name('update_password_submit');

});

require __DIR__ . '/auth.php';


Route::get('/restuarant-details/{client}', [HomeController::class, 'getRestuarantDetailsPage'])->name('restuarant_details');

// wishlist route 
Route::get('/restuarant/add-to-wishlist/{client}', [HomeController::class, 'restuarantAddToWishList'])->name('restuarant_add_to_withlist');
