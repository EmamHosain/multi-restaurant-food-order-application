<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CouponController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WishlistController;
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


    // wishlist auth route start here
    Route::get('/my-wishlists', [WishlistController::class, 'getAllWishlists'])->name('get_all_wishlists');
    Route::get('/remove-wishlist/{id}', [WishlistController::class, 'removeWishlist'])->name('remove_wishlist');
    // wishlist auth route end here


});

require __DIR__ . '/auth.php';


Route::get('/restuarant-details/{client}', [HomeController::class, 'getRestuarantDetailsPage'])->name('restuarant_details');

// wishlist route 
Route::get('/restuarant/add-to-wishlist/{client}', [WishlistController::class, 'restuarantAddToWishList'])->name('restuarant_add_to_withlist');


// user cart route start here
Route::controller(CartController::class)->name('user.cart.')->group(function () {
    Route::get('/add-to-cart/{product}', 'addToCart')->name('add_to_cart');
    Route::post('/update-cart-quantity', 'updateCartQuantity')->name('update_cart_quanaity');
    Route::post('/remove-from-cart', 'removeFromCart')->name('remove_cart');
});


// user coupon route start here
Route::controller(CouponController::class)->name('user.coupon.')->group(function () {

    Route::post('apply-coupon', 'applyCoupon')->name('apply_coupon');

    Route::get('remove-coupon', 'removeCoupon')->name('remove_coupon');

   
});
// user coupon route end here
