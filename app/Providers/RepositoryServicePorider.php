<?php

namespace App\Providers;

use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryContract;
use App\Repositories\Partner\PartnerRepository;
use App\Repositories\Partner\PartnerRepositoryContract;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryContract;
use Illuminate\Support\ServiceProvider;

class RepositoryServicePorider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            OrderRepositoryContract::class,
            OrderRepository::class
        );

        $this->app->bind(
            ProductRepositoryContract::class,
            ProductRepository::class
        );

        $this->app->bind(
            PartnerRepositoryContract::class,
            PartnerRepository::class
        );
    }
}
