<?php

namespace Misfits\Helpers\Development;

use Illuminate\Support\ServiceProvider;

/**
 * Class HelperServiceProvider
 *
 * @package Misfits\Helpers\Development
 */
class HelperServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/dev-helpers' => config_path('dev-helpers.php'),
            ], 'config');
        }
    }

    /**
     * Register the applicatiàon services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}