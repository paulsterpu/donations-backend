<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('password', function ($attribute, $value, $parameters, $validator) {

            $valid = false;

            if (preg_match('/\\d/', $value) === 1)
                $valid = $valid || true;

            if (strtoupper($value) !== $value && strtolower($value) !== $value)
                $valid = $valid || true;

            if (preg_match('/[ !@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $value) === 1)
                $valid = $valid || true;


            return $valid;

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
