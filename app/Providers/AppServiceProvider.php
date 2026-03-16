<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Purchase;
use App\Policies\PurchasePolicy;
use Illuminate\Support\Facades\Gate;


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
        Gate::policy(Purchase::class, PurchasePolicy::class);
    }
}
