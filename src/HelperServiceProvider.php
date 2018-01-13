<?php

namespace Misfits\Helpers\Development;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\ServiceProvider;
use Misfits\Helpers\Development\Commands\MakeTraitCommand;
use Misfits\Helpers\Development\Creators\TraitCreator;

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
                __DIR__ . '/config/dev-helpers.php' => config_path('dev-helpers.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
        $this->registerMakeTraitCommand();
        $this->mergeConfigFrom(__DIR__ . '/config/dev-helpers.php', 'dev-helpers');
    }

    /**
     * Register the bings for the Laravel package
     *
     * @return void
     */
    protected function registerBindings(): void
    {
        // FileSystem
        $this->app->instance('FileSystem', new FileSystem());

        // Composer
        $this->app->bind('Composer', function ($app): Composer {
            return new Composer($app['FileSystem']);
        });

        // Trait creator
        $this->app->singleton('TraitCreator', function ($app): TraitCreator {
            return new TraitCreator($app['FileSystem']);
        });
    }

    /**
     * Register the make:trait command.
     *
     * @return void
     */
    protected function registerMakeTraitCommand(): void
    {
        $this->app->singleton('command.trait.create', function ($app): MakeTraitCommand {
            return new MakeTraitCommand($app['TraitCreator'], $app['Composer']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provider(): array
    {
        return ['command.trait.create'];
    }
}