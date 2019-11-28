<?php

namespace Lwj\Rbac;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->registerRoutes();
        $this->registerResources();
        $this->defineAssetPublishing();
        $this->registerMigrations();
        $this->publishes([
            __DIR__.'/../config/rbac.php' => config_path('rbac.php')
        ], 'config');
    }


    /**
     * Register the Horizon routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'domain' => config('rbac.domain', null),
            'prefix' => config('rbac.path'),
            'namespace' => 'Lwj\Rbac\Https\Controllers',
            'middleware' => config('rbac.auth_middleware', 'api'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');
        });
        Route::group([
            'domain' => config('rbac.domain', null),
            'prefix' => config('rbac.path'),
            'namespace' => 'Lwj\Rbac\Https\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

    }

    /**
     * Register the resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-rbac');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            RABC_PATH.'/public' => public_path('vendor/rbac'),
        ], 'assets');
    }

    /**
     * Register the migrations.
     */
    public function registerMigrations()
    {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('');

        if (! defined('RABC_PATH')) {
            define('RABC_PATH', realpath(__DIR__.'/../'));
        }
    }

}
