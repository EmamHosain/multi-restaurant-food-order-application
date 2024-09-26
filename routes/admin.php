<?php
use App\Http\Controllers\Admin\AdminRoleManageController;
use App\Http\Controllers\Admin\RolePermissionManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleManageController;
use App\Http\Controllers\Admin\OrderManageController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\ReviewManageController;
use App\Http\Controllers\Admin\ProductManageController;
use App\Http\Controllers\Admin\ManageRestuarantController;
use App\Http\Controllers\Admin\PermissionManageController;


// guest route 
Route::middleware(['adminGuest'])->group(function () {
    Route::get('/login', [AdminController::class, 'login'])
        ->name('login_create');
    Route::post('/login', [AdminController::class, 'loginSubmit'])
        ->name('login_submit');
    Route::get('/forgot-password', [AdminController::class, 'forgotPassword'])
        ->name('forgot_password');
    Route::post('/forgot-password', [AdminController::class, 'sendEmailForgotPassword'])
        ->name('forgot_password_send_email');
    Route::get('/reset-password/{token}', [AdminController::class, 'resetPassword'])
        ->name('reset_password');
    Route::post('/reset-password', [AdminController::class, 'resetPasswordSubmit'])
        ->name('reset_password_submit');
});




// auth route
Route::middleware(['adminAuth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard_index');
    Route::get('/profile', [AdminProfileController::class, 'getProfile'])
        ->name('profile_index');
    Route::patch('/profile/update', [AdminProfileController::class, 'profileUpdate'])
        ->name('profile_update');
    Route::get('/update-password', [AdminProfileController::class, 'getUpdatePasswordPage'])
        ->name('update_password');
    Route::patch('/update-password', [AdminProfileController::class, 'getUpdatePasswordSubmit'])
        ->name('update_password_submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');



    // category route start here
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')
            ->name('all_categories')->middleware('permission:category_read');
        Route::get('/category/create', 'create')
            ->name('category_create')->middleware('permission:category_create');
        Route::post('/category/store', 'store')
            ->name('category_store')->middleware('permission:category_create');
        Route::get('/category/edit/{category}', 'edit')
            ->name('category_item_edit')->middleware('permission:category_edit');
        Route::patch('/category/update/{category}', 'update')
            ->name('category_item_update')->middleware('permission:category_edit');
        Route::get('/category/delete/{category}', 'destroy')
            ->name('category_item_delete')->middleware('permission:category_delete');
    });

    Route::controller(CityController::class)->group(function () {
        Route::get('/city', 'index')
            ->name('all_cities')->middleware('permission:city_read');
        Route::post('/city/store', 'store')
            ->name('city_store')->middleware('permission:city_create');
        Route::get('/city/edit/{id}', 'edit')
            ->name('city_item_edit')->middleware('permission:city_edit');
        Route::patch('/city/update', 'update')
            ->name('city_item_update')->middleware('permission:city_edit');
        Route::get('/city/delete/{city}', 'destroy')
            ->name('city_item_delete')->middleware('permission:city_delete');

    });



    // product manage route start 
    Route::controller(ProductManageController::class)->group(function () {
        Route::get('/all-products', 'index')
            ->name('all_products')->middleware('permission:product_read');
        Route::get('/product/create', 'create')
            ->name('product_create')->middleware('permission:product_create');
        Route::post('/product/store', 'store')
            ->name('product_store')->middleware('permission:product_create');
        Route::get('/product/edit/{product}', 'edit')
            ->name('product_edit')->middleware('permission:product_edit');
        Route::patch('/product/update/{product}', 'update')
            ->name('product_update')->middleware('permission:product_edit');
        Route::get('/product/delete/{product}', 'destroy')
            ->name('product_delete')->middleware('permission:product_delete');
    });
    // product manage route end 


    //restuarant management route start 
    Route::controller(ManageRestuarantController::class)->group(function () {
        Route::get('/change-status/inactive/{client}', 'setInactiveClient')
            ->name('set_inactive_client')->middleware('permission:set_restaurant_inactive');
        Route::get('/change-status/active/{client}', 'setActiveClient')
            ->name('set_active_client')->middleware('permission:set_restaurant_active');
        Route::get('/all-restuarants', 'allRestuarants')
            ->name('all_restuarants')->middleware('permission:restaurant_read');
        Route::get('/pending-all-restuarants', 'getPendingRestuarants')
            ->name('pending_restuarants')->middleware('permission:pending_restaurant_read');
        Route::get('/approved-all-restuarants', 'getApprovedRestuarants')
            ->name('approved_restuarants')->middleware('permission:approve_restaurant_read');
        Route::get('/restuarant/create', 'create')
            ->name('add_restuarant')->middleware('permission:restaurant_create');
        Route::post('/restuarant/store', 'store')
            ->name('restuarant_store')->middleware('permission:restaurant_create');
        Route::get('/restuarant/edit/{client}', 'edit')
            ->name('edit_restuarant')->middleware('permission:restaurant_edit');
        Route::patch('/restuarant/update/{client}', 'update')
            ->name('restuarant_update')->middleware('permission:restaurant_edit');
        Route::get('/restuarant/delete/{client}', 'destroy')
            ->name('restuarant_delete')->middleware('permission:restaurant_delete');
    });
    // restuarant management route end 



    // banner manage route start 
    Route::controller(BannerController::class)->group(function () {
        Route::get('/all-banners', 'index')
            ->name('all_banners')->middleware('permission:banner_read');
        Route::get('/banner/create', 'create')
            ->name('banner_create')->middleware('permission:banner_create');
        Route::post('/banner/store', 'store')
            ->name('banner_store')->middleware('permission:banner_create');
        Route::get('/banner/edit/{banner}', 'edit')
            ->name('banner_edit')->middleware('permission:banner_edit');
        Route::patch('/banner/update/{banner}', 'update')
            ->name('banner_update')->middleware('permission:banner_edit');
        Route::get('/banner/delete/{banner}', 'destroy')
            ->name('banner_delete')->middleware('permission:banner_delete');
    });
    // banner manage route end 



    // banner manage route start 
    Route::controller(OrderManageController::class)->group(function () {
        Route::get('/order-details/{id}', 'orderDetails')
            ->name('order_details')->middleware('permission:order_details');
        Route::get('/pending-orders', 'pendingOrders')
            ->name('pending_orders')->middleware('permission:pending_order_read');
        Route::get('/processing-orders', 'processingOrders')
            ->name('processing_orders')->middleware('permission:processing_order_read');
        Route::get('/confirmed-orders', 'confirmedOrders')
            ->name('confirmed_orders')->middleware('permission:confirm_order_read');
        Route::get('/deliverd-orders', 'deliverdOrders')
            ->name('deliverd_orders')->middleware('permission:deliverd_order_read');



        // pending to confirm order 
        Route::get('/pending-to-confirm-order/{order}', 'pendintToConfirm')
            ->name('pendint_to_confirm_order')->middleware('permission:pending_to_confirm_order');


        // confirm to processing order 
        Route::get('/confirm-to-processing/{order}', 'confirmToProcessing')
            ->name('confirm_to_processing_order')->middleware('permission:confirm_to_processing_order');


        //  processing to deliveried order 
        Route::get('/processing-to-deliverd/{order}', 'processingToDeliverd')
            ->name('processing_to_deliverd_order')->middleware('permission:processing_to_deliverd_order');
    });
    // banner manage route end 



    // report route  start here
    Route::controller(ReportController::class)->prefix('report')->group(function () {
        Route::get('/all-report', 'getAllReport')
            ->name('get_all_report');
        Route::post('/search-by-date', 'getAllReportByDate')
            ->name('get_all_report_by_date');
        Route::post('/search-by-month', 'getAllReportByMonth')
            ->name('get_all_report_by_month');
        Route::post('/search-by-year', 'getAllReportByYear')
            ->name('get_all_report_by_year');
    });
    // report route  end here



    // admin review manage start here
    Route::controller(ReviewManageController::class)->group(function () {
        Route::get('/pending-reviews', 'getAllPendingReviews')
            ->name('pending_reviews');
        Route::get('/approbed-reviews', 'getAllAppropedReviews')
            ->name('approbed_reviews');
        Route::get('/review-change-status', 'ReviewChangeStatus')
            ->name('review_change_status');
    });
    // admin review manage start here





    // admin  permission route start here
    Route::controller(PermissionManageController::class)->group(function () {
        Route::get('/all-permissions', 'getAllPermissions')
            ->name('get_all_permissions');
        Route::get('/add-permission', 'addPermission')
            ->name('add_permission');
        Route::get('/add-permission', 'addPermission')
            ->name('add_permission');
        Route::get('/edit-permission/{permission}', 'editPermission')
            ->name('edit_permission');
        Route::patch('/update-permission/{permission}', 'updatePermission')
            ->name('update_permission');
        Route::get('/delete-permission/{permission}', 'deletePermission')
            ->name('delete_permission');
        Route::post('/store-permission', 'storePermission')
            ->name('store_permission');


        // import
        Route::get('/import-permission', 'importPermission')
            ->name('import_permission');
        Route::post('/import-permission', 'importPermissionSubmit')
            ->name('import_permission_submit');

        // export
        Route::get('/export-permission', 'exportPermission')
            ->name('export_permission');

    });
    // admin  permission route end here




    // admin role route start here
    Route::controller(RoleManageController::class)->group(function () {
        Route::get('/roles', 'getAllRoles')
            ->name('get_all_roles');
        Route::get('/add-role', 'addRole')
            ->name('add_role');
        Route::post('/store-role', 'storeRole')
            ->name('store_role');
        Route::get('/edit-role/{role}', 'editRole')
            ->name('edit_role');
        Route::patch('/update-role/{role}', 'updateRole')
            ->name('update_role');
        Route::get('/delete-role/{role}', 'deleteRole')
            ->name('delete_role');
    });
    // admin role route start here







    // admin role and permission manage route start here
    Route::controller(RolePermissionManageController::class)->group(function () {
        Route::get('/add-role-in-permission', 'addRoleAndPermission')
            ->name('add_role_in_permission');
        Route::post('/assign-role-permission', 'assignRolePermission')
            ->name('assign_role_permission');
        Route::get('/all-role-and-permission', 'getAllRoleAndPermission')
            ->name('get_all_role_and_permission');
        Route::get('/edit-role-permission/{role}', 'editRoleAndPermission')
            ->name('edit_role_and_permission');
        Route::patch('/update-role-permission/{role}', 'updateRoleAndPermission')
            ->name('update_role_and_permission');
        Route::get('/delete-role-permission/{role}', 'deleteRoleAndPermission')
            ->name('delete_role_and_permission');

    });
    // admin role and permission manage route start here



    // admin role manage route start here
    Route::controller(AdminRoleManageController::class)->group(function () {
        Route::get('/all-admin', 'getAllAdmin')
            ->name('get_all_admin');
        Route::get('/add-admin', 'addAdmin')
            ->name('add_admin');
        Route::post('/store-admin', 'storeAdmin')
            ->name('store_admin');
        Route::get('/edit-admin/{admin}', 'editAdmin')
            ->name('edit_admin');
        Route::patch('/update-admin/{admin}', 'updateAdmin')
            ->name('update_admin');
        Route::get('/delete-admin/{admin}', 'deleteAdmin')
            ->name('delete_admin');
    });
    // admin role manage route end here












});
