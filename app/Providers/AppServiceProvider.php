<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

// Interfaces
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use App\Repositories\Interfaces\StockOpnameRepositoryInterface;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;
use App\Repositories\Interfaces\ActivityLogRepositoryInterface;

// Implementations
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\UserRepository;
use App\Repositories\StockTransactionRepository;
use App\Repositories\StockOpnameRepository;
use App\Repositories\ProductAttributeRepository;
use App\Repositories\ActivityLogRepository;

class AppServiceProvider extends ServiceProvider
{
    /*
    |--------------------------------------------------------------------------
    | REPOSITORY BINDINGS
    |--------------------------------------------------------------------------
    */

    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(StockTransactionRepositoryInterface::class, StockTransactionRepository::class);
        $this->app->bind(StockOpnameRepositoryInterface::class, StockOpnameRepository::class);
        $this->app->bind(ProductAttributeRepositoryInterface::class, ProductAttributeRepository::class);
        $this->app->bind(ActivityLogRepositoryInterface::class, ActivityLogRepository::class);
    }

    /*
    |--------------------------------------------------------------------------
    | BOOT — share pengaturan aplikasi ke semua view
    |--------------------------------------------------------------------------
    */

    public function boot(): void
    {
        // Guard: jangan jalankan saat tabel belum ada (misal: sebelum migrate)
        if (Schema::hasTable('settings')) {
            $appName = \App\Models\Setting::get('app_name', config('app.name', 'Stockify'));
            $appLogo = \App\Models\Setting::get('logo');

            View::share('appName', $appName);
            View::share('appLogo',  $appLogo);
        } else {
            View::share('appName', config('app.name', 'Stockify'));
            View::share('appLogo',  null);
        }
    }
}