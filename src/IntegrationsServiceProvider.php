<?php

namespace Keerill\Integrations;

use Illuminate\Support\ServiceProvider;

class IntegrationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../config/integrations.php' => config_path('integrations.php')]);
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/integrations.php', 'integrations'
        );

        $this->app->bind('integrations', function ($app) {
            return new \Keerill\Integrations\Classes\IntegrationManager(
                $app['config']['integrations']['default'], $app['config']['integrations']['drivers']
            );
        });
    }
}