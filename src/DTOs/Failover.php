<?php

namespace Vendor\HetznerRobot\DTOs;

class Failover
{
    public string $ip;

    public string $netmask;

    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    public string $activeServerIp;

    public static function fromArray(array $data): self
    {
        $failover = new self;
        $failover->ip = (string) ($data['ip'] ?? '');
        $failover->netmask = (string) ($data['netmask'] ?? '');
        $failover->serverIp = (string) ($data['server_ip'] ?? '');
        $failover->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $failover->serverNumber = (int) ($data['server_number'] ?? 0);
        $failover->activeServerIp = (string) ($data['active_server_ip'] ?? '');

        return $failover;
    }
}
