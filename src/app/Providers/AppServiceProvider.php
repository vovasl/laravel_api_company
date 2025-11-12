<?php

namespace App\Providers;

use App\Api\Repositories\CompanyRepository;
use App\Api\Repositories\Contracts\CompanyRepositoryInterface;
use App\Api\Services\CompanyVersionsService;
use App\Api\Services\Contracts\CompanyVersionsServiceInterface;
use App\Api\Services\Contracts\StoreCompanyServiceInterface;
use App\Api\Services\StoreCompanyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(StoreCompanyServiceInterface::class, StoreCompanyService::class);
        $this->app->bind(CompanyVersionsServiceInterface::class, CompanyVersionsService::class);
    }
}
