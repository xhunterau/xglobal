<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ProductObserver;
use App\Observers\BillObserver;
use App\Models\Product;
use App\Models\Bill;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //temporily solution to solve the update bugs of NOVA by Wayne 10/5/2019
        $this->app->bind('Laravel\Nova\Http\Controllers\ResourceUpdateController', 'App\Http\Controllers\Nova\ResourceUpdateController');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Product::observe(ProductObserver::class);
        Bill::observe(BillObserver::class);
    }
}
