<?php
declare(strict_types=1);

namespace agoalofalife\Reports;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ReportsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();
        $this->commands([
            Console\InstallCommand::class,
            Console\AssetsConsole::class,
            Console\SeederCommand::class,
        ]);
        $this->loadViews();
        $this->mergeConfigFrom(__DIR__.'/../config/reports.php.php', 'reports');
        $this->toPublish();
    }

    public function register()
    {
        if (! defined('REPORTS_PATH')) {
            define('POSTMAN_PATH', realpath(__DIR__.'/../'));
        }
    }

    protected function toPublish()
    {
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'reports-migration');
        $this->publishes([
            __DIR__.'/../config/postman.php' => config_path('reports.php'),
        ], 'reports-migration');
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/reports'),
        ], 'reports-migration');
        $this->publishes([
            REPORTS_PATH.'/public' => public_path('vendor/reports'),
        ], 'reports-assets');
        $this->publishes([
            __DIR__.'/../database/seeds' => database_path('seeds'),
        ], 'reports-migration');
        $this->publishes([
            __DIR__.'/../resources/assets/js/components' => base_path('resources/assets/js/components/reports'),
        ], 'reports-components');
    }

    protected function registerRoutes() : void
    {
        Route::group([
            'prefix' => 'reports',
            'namespace' => 'agoalofalife\reports\Http\Controllers',
            'middleware' => 'web',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
    protected function loadViews() : void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'reports');
    }
}