<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

            //Cách 1: Dùng Gate
//        Gate::define('view-category', function ($user) {
//            return $user->checkPermissionAcces('view_category');
//        });

        //Cách 2: Kết hợp Gate vs Polocie
        //======== Category ==========
        Gate::define('view-category', 'App\Policies\CategoryPolicy@view');
        Gate::define('add-category', 'App\Policies\CategoryPolicy@create');
        Gate::define('edit-category', 'App\Policies\CategoryPolicy@update');
        Gate::define('delete-category', 'App\Policies\CategoryPolicy@delete');

        //======== Product ==========
        Gate::define('view-product', 'App\Policies\ProductPolicy@view');
        Gate::define('add-product', 'App\Policies\ProductPolicy@create');
        Gate::define('edit-product', 'App\Policies\ProductPolicy@update');
        Gate::define('delete-product', 'App\Policies\ProductPolicy@delete');

        //======== Post ==========
        Gate::define('view-post', 'App\Policies\PostPolicy@view');
        Gate::define('add-post', 'App\Policies\PostPolicy@create');
        Gate::define('edit-post', 'App\Policies\PostPolicy@update');
        Gate::define('delete-post', 'App\Policies\PostPolicy@delete');

        //======== Order ==========
        Gate::define('view-order', 'App\Policies\OrderPolicy@view');
        Gate::define('detail-order', 'App\Policies\OrderPolicy@show');
        Gate::define('delete-order', 'App\Policies\OrderPolicy@delete');

        //======== Slider ==========
        Gate::define('view-slider', 'App\Policies\SliderPolicy@view');
        Gate::define('add-slider', 'App\Policies\SliderPolicy@create');
        Gate::define('edit-slider', 'App\Policies\SliderPolicy@update');
        Gate::define('delete-slider', 'App\Policies\SliderPolicy@delete');

        //======== Banner ==========
        Gate::define('view-banner', 'App\Policies\BannerPolicy@view');
        Gate::define('add-banner', 'App\Policies\BannerPolicy@create');
        Gate::define('edit-banner', 'App\Policies\BannerPolicy@update');
        Gate::define('delete-banner', 'App\Policies\BannerPolicy@delete');

        //======== Introduce ==========
        Gate::define('view-introduce', 'App\Policies\IntroducePolicy@view');
        Gate::define('update-introduce', 'App\Policies\IntroducePolicy@update');

        //======== Contact ==========
        Gate::define('view-contact', 'App\Policies\ContactPolicy@view');
        Gate::define('update-contact', 'App\Policies\ContactPolicy@update');

        //======== WareHouse ==========
        Gate::define('view-warehouse', 'App\Policies\WarehousePolicy@view');
        Gate::define('update-warehouse', 'App\Policies\WarehousePolicy@update');

        //======== Quản lí thành viên ==========
        Gate::define('view-admin', 'App\Policies\UserPolicy@view');
        Gate::define('add-admin', 'App\Policies\UserPolicy@create');
        Gate::define('edit-admin', 'App\Policies\UserPolicy@update');
        Gate::define('delete-admin', 'App\Policies\UserPolicy@delete');

        //======== Quản lí nhóm quyền ==========
        Gate::define('view-role', 'App\Policies\RolePolicy@view');
        Gate::define('add-role', 'App\Policies\RolePolicy@create');
        Gate::define('edit-role', 'App\Policies\RolePolicy@update');
        Gate::define('delete-role', 'App\Policies\RolePolicy@delete');

        //======== Chính sách mua hàng ==========
        Gate::define('view-purchase', 'App\Policies\PurchasePolicy@view');
        Gate::define('add-purchase', 'App\Policies\PurchasePolicy@create');
        Gate::define('edit-purchase', 'App\Policies\PurchasePolicy@update');
        Gate::define('delete-purchase', 'App\Policies\PurchasePolicy@delete');

        //======== Cài đặt ==========
        Gate::define('view-setting', 'App\Policies\SettingPolicy@view');
        Gate::define('update-setting', 'App\Policies\SettingPolicy@update');
    }
}
