<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ProductManageController;
use Illuminate\Support\Facades\Route;


// guest route 
Route::middleware(['adminGuest'])->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login_create');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login_submit');
    Route::get('/forgot-password', [AdminController::class, 'forgotPassword'])->name('forgot_password');
    Route::post('/forgot-password', [AdminController::class, 'sendEmailForgotPassword'])->name('forgot_password_send_email');
    Route::get('/reset-password/{token}', [AdminController::class, 'resetPassword'])->name('reset_password');
    Route::post('/reset-password', [AdminController::class, 'resetPasswordSubmit'])->name('reset_password_submit');
});




// auth route
Route::middleware(['adminAuth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard_index');
    Route::get('/profile', [AdminProfileController::class, 'getProfile'])->name('profile_index');
    Route::patch('/profile/update', [AdminProfileController::class, 'profileUpdate'])->name('profile_update');
    Route::get('/update-password', [AdminProfileController::class, 'getUpdatePasswordPage'])->name('update_password');
    Route::patch('/update-password', [AdminProfileController::class, 'getUpdatePasswordSubmit'])->name('update_password_submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');



    // category route start here
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('all_categories');
        Route::get('/category/create', 'create')->name('category_create');
        Route::post('/category/store', 'store')->name('category_store');
        Route::get('/category/edit/{category}', 'edit')->name('category_item_edit');
        Route::patch('/category/update/{category}', 'update')->name('category_item_update');
        Route::get('/category/delete/{category}', 'destroy')->name('category_item_delete');
    });

    Route::controller(CityController::class)->group(function () {
        Route::get('/city', 'index')->name('all_cities');
        Route::post('/city/store', 'store')->name('city_store');
        Route::get('/city/edit/{id}', 'edit')->name('city_item_edit');
        Route::patch('/city/update', 'update')->name('city_item_update');
        Route::get('/city/delete/{city}', 'destroy')->name('city_item_delete');
    });



    // product manage route start 
    Route::controller(ProductManageController::class)->group(function () {
        Route::get('/all-products', 'index')->name('all_products');
        Route::get('/product/create', 'create')->name('product_create');
        
        Route::post('/product/store', 'store')->name('product_store');
        Route::get('/product/edit/{product}', 'edit')->name('product_edit');
        Route::patch('/product/update/{product}', 'update')->name('product_update');
        Route::get('/product/delete/{product}', 'destroy')->name('product_delete');
    });
    // product manage route end 


});
