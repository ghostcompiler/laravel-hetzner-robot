<?php

namespace Vendor\HetznerRobot\DTOs;

class Ip
{
    public string $ip;

    public ?string $gateway = null;

    public ?int $mask = null;

    public ?string $broadcast = null;

    public string $serverIp;

    public int $serverNumber;

    public bool $locked;

    public ?string $separateMac = null;

    public bool $trafficWarnings;

    public int $trafficHourly;

    public int $trafficDaily;

    public int $trafficMonthly;

    public static function fromArray(array $data): self
    {
        $ip = new self;
        $ip->ip = (string) ($data['ip'] ?? '');
        $ip->gateway = isset($data['gateway']) ? (string) $data['gateway'] : null;
        $ip->mask = isset($data['mask']) ? (int) $data['mask'] : null;
        $ip->broadcast = isset($data['broadcast']) ? (string) $data['broadcast'] : null;
        $ip->serverIp = (string) ($data['server_ip'] ?? '');
        $ip->serverNumber = (int) ($data['server_number'] ?? 0);
        $ip->locked = (bool) ($data['locked'] ?? false);
        $ip->separateMac = isset($data['separate_mac']) ? (string) $data['separate_mac'] : null;
        $ip->trafficWarnings = (bool) ($data['traffic_warnings'] ?? false);
        $ip->trafficHourly = (int) ($data['traffic_hourly'] ?? 0);
        $ip->trafficDaily = (int) ($data['traffic_daily'] ?? 0);
        $ip->trafficMonthly = (int) ($data['traffic_monthly'] ?? 0);

        return $ip;
    }
}
