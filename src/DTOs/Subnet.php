<?php

namespace Vendor\HetznerRobot\DTOs;

class Subnet
{
    public string $ip;

    public int $mask;

    public string $gateway;

    public ?string $serverIp = null;

    public int $serverNumber;

    public bool $failover;

    public bool $locked;

    public bool $trafficWarnings;

    public int $trafficHourly;

    public int $trafficDaily;

    public int $trafficMonthly;

    public static function fromArray(array $data): self
    {
        $subnet = new self;
        $subnet->ip = (string) ($data['ip'] ?? '');
        $subnet->mask = (int) ($data['mask'] ?? 0);
        $subnet->gateway = (string) ($data['gateway'] ?? '');
        $subnet->serverIp = isset($data['server_ip']) ? (string) $data['server_ip'] : null;
        $subnet->serverNumber = (int) ($data['server_number'] ?? 0);
        $subnet->failover = (bool) ($data['failover'] ?? false);
        $subnet->locked = (bool) ($data['locked'] ?? false);
        $subnet->trafficWarnings = (bool) ($data['traffic_warnings'] ?? false);
        $subnet->trafficHourly = (int) ($data['traffic_hourly'] ?? 0);
        $subnet->trafficDaily = (int) ($data['traffic_daily'] ?? 0);
        $subnet->trafficMonthly = (int) ($data['traffic_monthly'] ?? 0);

        return $subnet;
    }
}
