<?php

namespace Vendor\HetznerRobot\DTOs;

class Linux
{
    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    /**
     * @var array|string
     */
    public $dist;

    /**
     * @var array|string
     */
    public $lang;

    public bool $active;

    public ?string $password = null;

    public array $authorizedKey = [];

    public array $hostKey = [];

    public static function fromArray(array $data): self
    {
        $linux = new self;
        $linux->serverIp = (string) ($data['server_ip'] ?? '');
        $linux->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $linux->serverNumber = (int) ($data['server_number'] ?? 0);
        $linux->dist = $data['dist'] ?? [];
        $linux->lang = $data['lang'] ?? [];
        $linux->active = (bool) ($data['active'] ?? false);
        $linux->password = isset($data['password']) ? (string) $data['password'] : null;
        $linux->authorizedKey = (array) ($data['authorized_key'] ?? []);
        $linux->hostKey = (array) ($data['host_key'] ?? []);

        return $linux;
    }
}
