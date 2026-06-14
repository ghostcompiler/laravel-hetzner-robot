<?php

namespace Vendor\HetznerRobot\Providers;

use Illuminate\Support\ServiceProvider;
use Vendor\HetznerRobot\Http\Client\HetznerClient;
use Vendor\HetznerRobot\Managers\HetznerManager;

class HetznerRobotServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/hetzner-robot.php',
            'hetzner-robot'
        );

        // Bind HetznerClient
        $this->app->singleton(HetznerClient::class, function ($app) {
            $config = $app['config']->get('hetzner-robot', []);

            return new HetznerClient($config['username'] ?? '', $config['password'] ?? '', $config);
        });

        // Bind HetznerManager
        $this->app->singleton(HetznerManager::class, function ($app) {
            return new HetznerManager($app->make(HetznerClient::class));
        });

        // Register aliases
        $this->app->alias(HetznerManager::class, 'hetzner-robot');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/hetzner-robot.php' => config_path('hetzner-robot.php'),
            ], 'config');
        }
    }
}
