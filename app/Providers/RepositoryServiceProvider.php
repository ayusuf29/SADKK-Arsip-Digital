<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\SuratRepositoryInterface::class,
            \App\Repositories\Implementations\SuratRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\InvoiceRepositoryInterface::class,
            \App\Repositories\Implementations\InvoiceRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\PerjanjianKreditRepositoryInterface::class,
            \App\Repositories\Implementations\PerjanjianKreditRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\Implementations\UserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
