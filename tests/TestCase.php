<?php

namespace Vendor\HetznerRobot\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vendor\HetznerRobot\Facades\HetznerRobot;
use Vendor\HetznerRobot\Providers\HetznerRobotServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HetznerRobotServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'HetznerRobot' => HetznerRobot::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default config
        $app['config']->set('hetzner-robot.username', 'test-username');
        $app['config']->set('hetzner-robot.password', 'test-password');
        $app['config']->set('hetzner-robot.base_url', 'https://robot-ws.your-server.de');
    }
}
