<?php

namespace App\Providers;

use App\Purchase_policy;
use App\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Cách 1:
        View::composer(['fontend.elements.footter', 'fontend.elements.header', 'fontend.home'], function ($view) {
            $settting = Setting::find(1);
            $view->with('setting', $settting);
        });

        //Cách 2:
        //============ Chính sách mua hàng =========
        $purchasePolicy = Purchase_policy::where('status', 1)->get();
        View::share('purchasePolicy', $purchasePolicy);
    }
}
