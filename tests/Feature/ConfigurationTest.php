<?php

namespace Vendor\HetznerRobot\Tests\Feature;

use Vendor\HetznerRobot\Http\Client\HetznerClient;
use Vendor\HetznerRobot\Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_config_values_are_loaded()
    {
        $this->assertEquals('test-username', config('hetzner-robot.username'));
        $this->assertEquals('test-password', config('hetzner-robot.password'));
        $this->assertEquals('https://robot-ws.your-server.de', config('hetzner-robot.base_url'));
    }

    public function test_client_receives_config_values()
    {
        $this->app['config']->set('hetzner-robot.username', 'custom-username');
        $this->app['config']->set('hetzner-robot.password', 'custom-password');
        $this->app['config']->set('hetzner-robot.timeout', 45);

        // Re-resolve client to apply changes
        $client = $this->app->make(HetznerClient::class);

        $reflection = new \ReflectionClass($client);
        $usernameProp = $reflection->getProperty('username');
        $usernameProp->setAccessible(true);
        $passwordProp = $reflection->getProperty('password');
        $passwordProp->setAccessible(true);
        $timeoutProp = $reflection->getProperty('timeout');
        $timeoutProp->setAccessible(true);

        $this->assertEquals('custom-username', $usernameProp->getValue($client));
        $this->assertEquals('custom-password', $passwordProp->getValue($client));
        $this->assertEquals(45, $timeoutProp->getValue($client));
    }
}
