<?php

namespace App\Providers;

use App\Models\Setting;
use App\Support\AdminUnreadCounts;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Paginator::defaultView('pagination.simple');

        View::composer('*', function ($view) {
            try {
                $view->with('school', Schema::hasTable('settings') ? Setting::allCached() : []);
            } catch (\Throwable) {
                $view->with('school', []);
            }
        });

        View::composer('layouts.admin', function ($view) {
            try {
                $view->with('adminUnreadCounts', AdminUnreadCounts::get());
            } catch (\Throwable) {
                $view->with('adminUnreadCounts', [
                    'messages' => 0,
                    's1_admissions' => 0,
                    's5_admissions' => 0,
                    'continuing_admissions' => 0,
                    'admissions' => 0,
                    'total' => 0,
                ]);
            }
        });
    }
}
