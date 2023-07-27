<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
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
        $this->customs_validations();

        $this->custom_pagination();
    }


    public function customs_validations()
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        Validator::extend('without_only_spaces', function($attr, $value){
            return preg_match('/^\S$/u', $value);
        });
    }

    function custom_pagination() {
        Paginator::useBootstrap();
        // Paginator::defaultView('views.vendor.pagination.bootstrap-4');
        // Paginator::defaultSimpleView('view-name');
    }
}
