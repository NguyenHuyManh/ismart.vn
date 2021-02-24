<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//============================================ Back End ===========================================
Route::namespace('Backend')->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'DashboardController@login')->middleware('CheckLoginedAdmin');
        Route::get('login', 'DashboardController@login')->middleware('CheckLoginedAdmin');
        Route::post('login', [
            'as' => 'admin.check_login',
            'uses' => 'DashboardController@checklogin'
        ]);
        Route::get('logout', [
            'as' => 'admin.logout',
            'uses' => 'DashboardController@logout'
        ]);
        //=============== Quên mật khẩu =================
        Route::get('password/reset', [
            'as' => 'admin.get.reset.password',
            'uses' => 'AdminForgotPasswordController@getFormResetPassword'
        ]);
        Route::post('password/reset', [
            'as' => 'admin.send.reset.password',
            'uses' => 'AdminForgotPasswordController@sendMailResetPassword'
        ]);
        Route::get('password-reset', [
            'as' => 'admin.link.reset.password',
            'uses' => 'AdminForgotPasswordController@resetPassword'
        ]);
        Route::post('password-reset', [
            'as' => 'admin.save.reset.password',
            'uses' => 'AdminForgotPasswordController@saveResetPassword'
        ]);
    });
});

Route::namespace('Backend')->group(function () {
    Route::group(['prefix' => 'admin', 'middleware' => 'CheckLoginAdmin'], function () {
        Route::get('dashboard', 'DashboardController@index');

        //=============================== Danh mục sản phẩm ==============================
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [
                'as' => 'admin.category.index',
                'uses' => 'AdminCategoryController@index',
                'middleware' => 'can:view-category'
            ]);
            Route::get('create', [
                'as' => 'admin.category.create',
                'uses' => 'AdminCategoryController@create',
                'middleware' => 'can:add-category'
            ]);
            Route::post('store', [
                'as' => 'admin.category.store',
                'uses' => 'AdminCategoryController@store'
            ]);
            Route::get('edit/{id}', [
                'as' => 'admin.category.edit',
                'uses' => 'AdminCategoryController@edit',
                'middleware' => 'can:edit-category'
            ]);
            Route::post('update/{id}', [
                'as' => 'admin.category.update',
                'uses' => 'AdminCategoryController@update'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.category.destroy',
                'uses' => 'AdminCategoryController@destroy',
                'middleware' => 'can:delete-category'
            ]);
            //============= Ẩn - hiện danh mục ===========
            Route::get('update-status/{id}', [
                'as' => 'admin.category.update_status',
                'uses' => 'AdminCategoryController@updateStatus'
            ]);
        });

        //====================================== Sản phẩm ================================
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [
                'as' => 'admin.product.index',
                'uses' => 'AdminProductController@index',
                'middleware' => 'can:view-product'
            ]);
            Route::get('create', [
                'as' => 'admin.product.create',
                'uses' => 'AdminProductController@create',
                'middleware' => 'can:add-product'
            ]);
            Route::post('store', [
                'as' => 'admin.product.store',
                'uses' => 'AdminProductController@store'
            ]);
            Route::get('edit-product/{id}', [
                'as' => 'admin.product.edit',
                'uses' => 'AdminProductController@edit',
                'middleware' => 'can:edit-product'
            ]);
            Route::post('update-product/{id}', [
                'as' => 'admin.product.update',
                'uses' => 'AdminProductController@update'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.product.destroy',
                'uses' => 'AdminProductController@destroy',
                'middleware' => 'can:delete-product'
            ]);
            //========== Thùng rác =========
            Route::get('product-trashed', [
                'as' => 'admin.product.trashed',
                'uses' => 'AdminProductController@trashed'
            ]);
            //========= Tác vụ ===========
            Route::get('action', 'AdminProductController@action');
            //============= Cập nhật trạng thái ẩn - hiện sản phẩm ===========
            Route::get('update-status/{id}', [
                'as' => 'admin.product.update_status',
                'uses' => 'AdminProductController@updateStatus'
            ]);
            //============= Cập nhật nổi bật sản phẩm ===========
            Route::get('update-highlight/{id}', [
                'as' => 'admin.product.update_highlight',
                'uses' => 'AdminProductController@updateHighlight'
            ]);
            //============ Phân trang Ajax ===============
            Route::get('paginate-ajax', [
                'as' => 'admin.product.paginate_ajax',
                'uses' => 'AdminProductController@paginateAjax'
            ]);
        });


        //======================================== Bài viết ===================================
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', [
                'as' => 'admin.post.index',
                'uses' => 'AdminPostController@index',
                'middleware' => 'can:view-post'
            ]);
            Route::get('create', [
                'as' => 'admin.post.create',
                'uses' => 'AdminPostController@create',
                'middleware' => 'can:add-post'
            ]);
            Route::post('create', [
                'as' => 'admin.post.store',
                'uses' => 'AdminPostController@store'
            ]);
            Route::get('edit/{id}', [
                'as' => 'admin.post.edit',
                'uses' => 'AdminPostController@edit',
                'middleware' => 'can:edit-post'
            ]);
            Route::post('update/{id}', [
                'as' => 'admin.post.update',
                'uses' => 'AdminPostController@update'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.post.destroy',
                'uses' => 'AdminPostController@destroy',
                'middleware' => 'can:delete-post'
            ]);
            //============= Tác vụ =========
            Route::get('action', [
                'as' => 'admin.post.action',
                'uses' => 'AdminPostController@action'
            ]);
            //======= Thùng rác ======
            Route::get('post-trashed', [
                'as' => 'admin.post.trashed',
                'uses' => 'AdminPostController@trashed'
            ]);
            //====== Cập nhật trạng thái ẩn - hiện bài viết =====
            Route::get('update-status/{id}', [
                'as' => 'admin.post.update_status',
                'uses' => 'AdminPostController@updateStatus'
            ]);
        });

        //========================================== Slider =================================
        Route::group(['prefix' => 'slider'], function () {
            Route::get('/', [
                'as' => 'admin.slider.index',
                'uses' => 'AdminSliderController@index',
                'middleware' => 'can:view-slider'
            ]);
            Route::post('store', [
                'as' => 'admin.slider.store',
                'uses' => 'AdminSliderController@store',
                'middleware' => 'can:add-slider'
            ]);
            Route::get('edit/{id}', [
                'as' => 'admin.slider.edit',
                'uses' => 'AdminSliderController@edit',
                'middleware' => 'can:edit-slider'
            ]);
            Route::post('update/{id}', [
                'as' => 'admin.slider.update',
                'uses' => 'AdminSliderController@update'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.slider.destroy',
                'uses' => 'AdminSliderController@destroy',
                'middleware' => 'can:delete-slider'
            ]);
            //====== Cập nhật trạng thái ẩn - hiện Slider =====
            Route::get('update-status/{id}', [
                'as' => 'admin.slider.update_status',
                'uses' => 'AdminSliderController@updateStatus'
            ]);
        });

        //========================================== Banner =================================
        Route::group(['prefix' => 'banner'], function () {
            Route::get('/', [
                'as' => 'admin.banner.index',
                'uses' => 'AdminBannerController@index',
                'middleware' => 'can:view-banner'
            ]);
            Route::post('create', [
                'as' => 'admin.banner.store',
                'uses' => 'AdminBannerController@store',
                'middleware' => 'can:add-banner'
            ]);
            Route::get('edit/{id}', [
                'as' => 'admin.banner.edit',
                'uses' => 'AdminBannerController@edit',
                'middleware' => 'can:edit-banner'
            ]);
            Route::post('update/{id}', [
                'as' => 'admin.banner.update',
                'uses' => 'AdminBannerController@update'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.banner.destroy',
                'uses' => 'AdminBannerController@destroy',
                'middleware' => 'can:delete-banner'
            ]);
            //====== Cập nhật trạng thái ẩn - hiện Banner =====
            Route::get('update-status/{id}', [
                'as' => 'admin.banner.update_status',
                'uses' => 'AdminBannerController@updateStatus'
            ]);
        });

        //========================================= Giới thiệu =========================
        Route::group(['prefix' => 'introduce'], function () {
            Route::get('/', [
                'as' => 'admin.introduce.index',
                'uses' => 'AdminIntroduceController@index',
                'middleware' => 'can:view-introduce'
            ]);
            Route::post('/', [
                'as' => 'admin.introduce.store',
                'uses' => 'AdminIntroduceController@update',
                'middleware' => 'can:update-introduce'
            ]);
        });

        //========================================= Liên hệ =============================
        Route::group(['prefix' => 'contact'], function () {
            Route::get('/', [
                'as' => 'admin.contact.index',
                'uses' => 'AdminContactController@index',
                'middleware' => 'can:view-contact'
            ]);
            Route::post('/', [
                'as' => 'admin.contact.store',
                'uses' => 'AdminContactController@update',
                'middleware' => 'can:update-contact'
            ]);
        });

        //====================================== Kho hàng ===========================
        Route::group(['prefix' => 'warehouse'], function () {
            Route::get('/', [
                'as' => 'admin.warehouse.index',
                'uses' => 'AdminWarehouseController@index',
                'middleware' => 'can:view-warehouse'
            ]);
            Route::get('update-amount-product/{id}', [
                'as' => 'admin.warehouse.updateAmountProduct',
                'uses' => 'AdminWarehouseController@updateAmountProduct',
                'middleware' => 'can:update-warehouse'
            ]);
        });

        //========================================== User ================================
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [
                'as' => 'admin.user.index',
                'uses' => 'AdminUserController@index',
                'middleware' => 'can:view-admin'
            ]);
            Route::get('create', [
                'as' => 'admin.user.create',
                'uses' => 'AdminUserController@create',
                'middleware' => 'can:add-admin'
            ]);
            Route::post('store', [
                'as' => 'admin.user.store',
                'uses' => 'AdminUserController@store'
            ]);
            Route::get('edit/{id}', [
                'as' => 'admin.user.edit',
                'uses' => 'AdminUserController@edit',
                'middleware' => 'can:edit-admin'
            ]);
            Route::post('update/{id}', [
                'as' => 'admin.user.update',
                'uses' => 'AdminUserController@update',
                'middleware' => 'can:edit-admin'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.user.destroy',
                'uses' => 'AdminUserController@destroy',
                'middleware' => 'can:delete-admin'
            ]);
            //===== Thông tin tài khoản admin
            Route::get('account/{id}', [
                'as' => 'admin.user.info_account',
                'uses' => 'AdminUserController@infoAccount'
            ]);
            Route::post('update-account/{id}', [
                'as' => 'admin.user.update_account',
                'uses' => 'AdminUserController@updateInfoAccount'
            ]);
        });

        //========================================= Đơn hàng ======================================
        Route::group(['prefix' => 'order'], function () {
            Route::get('/', [
                'as' => 'admin.order.index',
                'uses' => 'AdminOrderController@index',
                'middleware' => 'can:view-order'
            ]);
            Route::get('detail-order/{id}', [
                'as' => 'admin.order.show',
                'uses' => 'AdminOrderController@show',
                'middleware' => 'can:detail-order'
            ]);
            Route::post('update-status/{id}', [
                'as' => 'admin.order.update_status',
                'uses' => 'AdminOrderController@update'
            ]);
            Route::get('delete-order/{id}', [
                'as' => 'admin.order.destroy',
                'uses' => 'AdminOrderController@destroy',
                'middleware' => 'can:delete-order'
            ]);
            Route::get('print-order/{id}', [
                'as' => 'admin.order.print_order',
                'uses' => 'AdminOrderController@printOrder',

            ]);
        });

        //========================================= Quản lý nhóm quyền ============================
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [
                'as' => 'admin.role.index',
                'uses' => 'AdminRoleController@index',
                'middleware' => 'can:view-role'
            ]);
            Route::get('create', [
                'as' => 'admin.role.create',
                'uses' => 'AdminRoleController@create',
                'middleware' => 'can:add-role'
            ]);
            Route::post('store', [
                'as' => 'admin.role.store',
                'uses' => 'AdminRoleController@store'
            ]);
            Route::get('edit/{id}', [
                'as' => 'admin.role.edit',
                'uses' => 'AdminRoleController@edit',
                'middleware' => 'can:edit-role'
            ]);
            Route::post('update/{id}', [
                'as' => 'admin.role.update',
                'uses' => 'AdminRoleController@update'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.role.destroy',
                'uses' => 'AdminRoleController@destroy',
                'middleware' => 'can:delete-role'
            ]);
        });

        //======================= Chính sách mua hàng =================
        Route::group(['prefix' => 'purchase-policy'], function () {
            Route::get('/', [
                'as' => 'admin.purchase_policy.index',
                'uses' => 'AdminPurchasePolicyController@index',
                'middleware' => 'can:view-purchase'
            ]);
            Route::get('create', [
                'as' => 'admin.purchase_policy.create',
                'uses' => 'AdminPurchasePolicyController@create',
                'middleware' => 'can:add-purchase'
            ]);
            Route::post('store', [
                'as' => 'admin.purchase_policy.store',
                'uses' => 'AdminPurchasePolicyController@store'
            ]);
            Route::get('edit/{id}', [
                'as' => 'admin.purchase_policy.edit',
                'uses' => 'AdminPurchasePolicyController@edit',
                'middleware' => 'can:edit-purchase'
            ]);
            Route::post('update/{id}', [
                'as' => 'admin.purchase_policy.update',
                'uses' => 'AdminPurchasePolicyController@update'
            ]);
            Route::get('delete/{id}', [
                'as' => 'admin.purchase_policy.destroy',
                'uses' => 'AdminPurchasePolicyController@destroy',
                'middleware' => 'can:delete-purchase'
            ]);
            //====== Cập nhật trạng thái ẩn - hiện =======
            Route::get('update-status/{id}', [
                'as' => 'admin.purchase_policy.update_status',
                'uses' => 'AdminPurchasePolicyController@updateStatus'
            ]);
        });

        //======================= Cấu hình ====================
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [
                'as' => 'admin.setting.index',
                'uses' => 'AdminSettingController@index',
                'middleware' => 'can:view-setting'
            ]);
            Route::post('update', [
                'as' => 'admin.setting.update',
                'uses' => 'AdminSettingController@update',
                'middleware' => 'can:update-setting'
            ]);
        });
    });
});


//=============================================== Font end ============================================

Route::namespace('Fontend')->group(function () {
    Route::group(['prefix' => '/'], function () {
        Route::get('/', 'HomeController@index');
        Route::get('search', 'HomeController@searchProduct')->name('search.product');

        //========================================= Đăng nhập - đăng kí ======================================
        Route::get('login', 'LoginController@login')->middleware('CheckLoginedUser');
        Route::post('login', [
            'as' => 'user.login',
            'uses' => 'LoginController@postLogin'
        ]);

        //=============== Đăng kí =========
        Route::get('register', 'RegisterController@register');
        Route::post('register', [
            'as' => 'user.register',
            'uses' => 'RegisterController@postRegister'
        ]);

        //=============== Đăng xuất =========
        Route::get('logout', [
            'as' => 'user.logout',
            'uses' => 'LoginController@logout'
        ]);

        //========================================= Quên mật khẩu =======================================
        Route::get('password/reset', [
            'as' => 'get.form.reset_password',
            'uses' => 'ForgotPasswordController@getFormResetPassword'
        ]);
        Route::post('password/reset', [
            'as' => 'send.email.reset_password',
            'uses' => 'ForgotPasswordController@sendMailRessetPassword'
        ]);
        Route::get('password-reset', [
            'as' => 'link.reset_password',
            'uses' => 'ForgotPasswordController@resetPassword'
        ]);
        Route::post('password-reset', 'ForgotPasswordController@saveResetPassword');

        //============================= Thông tin tài khoản ============================================
        Route::group(['prefix' => 'user', 'middleware' => 'CheckLoginUser'], function () {
            Route::get('account/{id}', [
                'as' => 'user.acount_info',
                'uses' => 'AccountController@userInfo'
            ]);
            //==== Cập nhật thông tin tài khoản ====
            Route::post('update-info/{id}', [
                'as' => 'user.update_account_info',
                'uses' => 'AccountController@updateAccountInfo'
            ]);
            //==== Đơn hàng đã mua ===
            Route::get('purchase/{id}', [
                'as' => 'user.purchase',
                'uses' => 'AccountController@purchase'
            ]);
            //==== Xem chi tiết đơn hàng ===
            Route::get('view-order/{id}', [
                'as' => 'user.view_order',
                'uses' => 'AccountController@viewOrder'
            ]);
            //===== Thay đổi mật khẩu ======
            Route::get('change-password/{id}', [
                'as' => 'user.change_password',
                'uses' => 'AccountController@changePassword'
            ]);
            Route::post('change-password/{id}', [
                'as' => 'user.save_change_password',
                'uses' => 'AccountController@saveChangePassword'
            ]);
        });
        //========================================= Giỏ hàng - Thanh toán ======================================
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', [
                'as' => 'cart.index',
                'uses' => 'CartController@index',
                'middleware' => 'CheckLoginUser'
            ]);
            Route::get('/add/{id}', [
                'as' => 'cart.add',
                'uses' => 'CartController@add'
            ]);
            Route::get('/buy-now/{id}', [
                'as' => 'cart.buy_now',
                'uses' => 'CartController@buyNow',
                'middleware' => 'CheckLoginUser'
            ]);
            Route::get('remove/{rowId}', [
                'as' => 'cart.remove',
                'uses' => 'CartController@remove',
                'middleware' => 'CheckLoginUser'
            ]);
            Route::get('destroy', [
                'as' => 'cart.destroy',
                'uses' => 'CartController@destroy',
                'middleware' => 'CheckLoginUser'
            ]);
            Route::get('update', [
                'as' => 'cart.update',
                'uses' => 'CartController@update',
                'middleware' => 'CheckLoginUser'
            ]);

            //====== THanh toán=====
            Route::get('thanh-toan', [
                'as' => 'order.checkout',
                'uses' => 'OrderController@checkOut',
                'middleware' => 'CheckLoginUser'
            ]);

            Route::post('thanh-toan', [
                'as' => 'order.save',
                'uses' => 'OrderController@saveOrder',
                'middleware' => 'CheckLoginUser'
            ]);

        });

        //====================================== Liên hệ =================================
        Route::group(['prefix' => 'lien-he'], function () {
            Route::get('/', [
                'as' => 'contact.index',
                'uses' => 'ContactController@index'
            ]);
        });

        //====================================== Giới thiệu =================================
        Route::group(['prefix' => 'gioi-thieu'], function () {
            Route::get('/', [
                'as' => 'intro.index',
                'uses' => 'IntroduceController@index'
            ]);
        });

        //========================================= Tin tức ======================================
        Route::group(['prefix' => 'tin-tuc'], function () {
            Route::get('/', [
                'as' => 'post.index',
                'uses' => 'PostController@index'
            ]);
            Route::get('{slug}/{id}', [
                'as' => 'post.show',
                'uses' => 'PostController@show'
            ]);
        });

        //======================================== Chính sách mua hàng =======================
        Route::group(['prefix' => 'chinh-sach'], function () {
            Route::get('{slug}/{id}', [
                'as' => 'purchase_policy.show',
                'uses' => 'PurchasePolicyController@show'
            ]);
        });

        //========================================= Chi tiết sẩn phẩm =================================
        Route::get('{category}/{slug}/{id}', [
            'as' => 'product.detail',
            'uses' => 'HomeController@show'
        ]);

        //========================================= Danh mục sản phẩm ========================
        Route::get('{slug}/{id}', [
            'as' => 'category.product',
            'uses' => 'CategoryController@index'
        ]);
    });
});
