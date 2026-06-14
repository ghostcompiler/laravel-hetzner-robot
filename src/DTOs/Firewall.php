<?php

namespace Vendor\HetznerRobot\DTOs;

class Firewall
{
    public string $serverIp;

    public int $serverNumber;

    public string $status;

    public bool $filterIpv6;

    public bool $whitelistHos;

    public string $port;

    public array $rules = [];

    public static function fromArray(array $data): self
    {
        $firewall = new self;
        $firewall->serverIp = (string) ($data['server_ip'] ?? '');
        $firewall->serverNumber = (int) ($data['server_number'] ?? 0);
        $firewall->status = (string) ($data['status'] ?? '');
        $firewall->filterIpv6 = (bool) ($data['filter_ipv6'] ?? false);
        $firewall->whitelistHos = (bool) ($data['whitelist_hos'] ?? false);
        $firewall->port = (string) ($data['port'] ?? '');
        $firewall->rules = (array) ($data['rules'] ?? []);

        return $firewall;
    }
}
