<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        Validator::extend('mobile', function ($attribute, $value, $parameters) {
            return preg_match('/^1[3-8]\d{9}$/', $value);
        });
    }
}
