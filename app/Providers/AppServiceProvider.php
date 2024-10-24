<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Opcodes\LogViewer\Facades\LogViewer;

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
        Paginator::useBootstrapFive();
        // Validator::extend('phone_vietnam', function ($attribute, $value, $parameters, $validator) {
        //     return preg_match('/^(0[1-9][0-9]{8,9})$/', $value);
        // });

        LogViewer::auth(function ($request) {
            return true;
        });
    }
}
