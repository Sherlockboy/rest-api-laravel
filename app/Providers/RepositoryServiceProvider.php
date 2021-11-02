<?php

namespace App\Providers;

use App\Http\Repositories\Eloquent\CategoryRepository;
use App\Http\Repositories\Eloquent\ProductRepository;
use App\Http\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
