<?php

namespace Waap\Vendus\Providers;

use Illuminate\Support\ServiceProvider;

class VendusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->setConfigurations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setPublishableFiles();

        // Load translations from custom path
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'vendus');
    }

    /**
     * Sets the configuration files.
     */
    private function setConfigurations()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/vendus.php', 'vendus'
        );
    }

    /**
     * Sets the publishable files.
     */
    private function setPublishableFiles()
    {
        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/vendus'),
        ], 'translations');

        $this->publishes([
            __DIR__ . '/../../config/vendus.php' => config_path('vendus.php'),
        ], 'config');
    }
}
