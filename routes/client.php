<?php
use App\Http\Controllers\Client\MenuController;
use App\Http\Controllers\Client\ProductController;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ClientProfileController;



// guest route 
Route::middleware(['clientGuest'])->group(function () {
    Route::get('/login', [ClientController::class, 'clientLogin'])->name('login_page');
    Route::post('/login', [ClientController::class, 'clientLoginSubmit'])->name('login_submit');
    Route::get('/register', [ClientController::class, 'clientRegister'])->name('register_page');
    Route::post('/register', [ClientController::class, 'clientRegisterSubmit'])->name('register_submit');
});





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


    // menu route start
    Route::controller(MenuController::class)->group(function () {
        Route::get('/all-menu', 'index')->name('all_menu');
        Route::get('/menu/create', 'create')->name('menu_create');
        Route::post('/menu/store', 'store')->name('menu_store');
        Route::get('/menu/edit/{menu}', 'edit')->name('menu_edit');
        Route::patch('/menu/update/{menu}', 'update')->name('menu_update');
        Route::get('/menu/delete/{menu}', 'destroy')->name('menu_delete');
    });
    // menu route end




    // product route start
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('all_products');
        Route::get('/product/create', 'create')->name('product_create');
        Route::post('/product/store', 'store')->name('product_store');
        Route::get('/product/edit/{product}', 'edit')->name('product_edit');
        Route::patch('/product/update/{product}', 'update')->name('product_update');
        Route::get('/product/delete/{product}', 'destroy')->name('product_delete');
    });
    // product route end


});
