<?php

namespace Vendor\HetznerRobot\Facades;

use Illuminate\Support\Facades\Facade;
use Vendor\HetznerRobot\Managers\HetznerManager;

/**
 * @method static \Vendor\HetznerRobot\Managers\HetznerManager authenticate(string $username, string $password)
 * @method static \Vendor\HetznerRobot\Managers\ServerManager servers()
 * @method static \Vendor\HetznerRobot\Managers\IpManager ips()
 * @method static \Vendor\HetznerRobot\Managers\SubnetManager subnets()
 * @method static \Vendor\HetznerRobot\Managers\ResetManager resets()
 * @method static \Vendor\HetznerRobot\Managers\FailoverManager failovers()
 * @method static \Vendor\HetznerRobot\Managers\WolManager wols()
 * @method static \Vendor\HetznerRobot\Managers\BootManager boots()
 * @method static \Vendor\HetznerRobot\Managers\RdnsManager rdns()
 * @method static \Vendor\HetznerRobot\Managers\TrafficManager traffic()
 * @method static \Vendor\HetznerRobot\Managers\SshKeyManager sshKeys()
 * @method static \Vendor\HetznerRobot\Managers\OrderManager orders()
 * @method static \Vendor\HetznerRobot\Managers\StorageBoxManager storageBoxes()
 * @method static \Vendor\HetznerRobot\Managers\FirewallManager firewalls()
 * @method static \Vendor\HetznerRobot\Managers\VSwitchManager vswitches()
 * @method static bool ping()
 * @method static string version()
 * @method static array rateLimit()
 * @method static array health()
 * @method static array config()
 * @method static \Vendor\HetznerRobot\Http\Client\HetznerClient client()
 * @method static array batch(array $callbacks)
 *
 * @see HetznerManager
 */
class HetznerRobot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hetzner-robot';
    }
}
