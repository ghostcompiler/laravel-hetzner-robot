<?php

namespace Vendor\HetznerRobot\Tests\Feature;

use Vendor\HetznerRobot\Facades\HetznerRobot;
use Vendor\HetznerRobot\Http\Client\HetznerClient;
use Vendor\HetznerRobot\Managers\HetznerManager;
use Vendor\HetznerRobot\Managers\ServerManager;
use Vendor\HetznerRobot\Managers\VSwitchManager;
use Vendor\HetznerRobot\Tests\TestCase;

class LaravelIntegrationTest extends TestCase
{
    public function test_facade_resolves_to_manager()
    {
        $manager = HetznerRobot::getFacadeRoot();
        $this->assertInstanceOf(HetznerManager::class, $manager);
    }

    public function test_container_resolves_singleton_manager()
    {
        $manager1 = $this->app->make(HetznerManager::class);
        $manager2 = $this->app->make('hetzner-robot');

        $this->assertSame($manager1, $manager2);
    }

    public function test_container_resolves_singleton_client()
    {
        $client = $this->app->make(HetznerClient::class);
        $manager = $this->app->make(HetznerManager::class);

        $this->assertSame($client, $manager->client());
    }

    public function test_facade_submanagers()
    {
        $this->assertInstanceOf(ServerManager::class, HetznerRobot::servers());
        $this->assertInstanceOf(VSwitchManager::class, HetznerRobot::vswitches());
    }
}
