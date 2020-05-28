<?php

namespace App\Providers;

use App\Repositories\Category\EloquentCategory;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\EloquentProduct;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Offer\OfferRepository;
use App\Repositories\Offer\EloquentOffer;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoryRepository::class, EloquentCategory::class);
        $this->app->singleton(ProductRepository::class, EloquentProduct::class);
        $this->app->singleton(OfferRepository::class, EloquentOffer::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
