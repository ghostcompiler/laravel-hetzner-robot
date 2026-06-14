<?php

namespace Vendor\HetznerRobot\DTOs;

class Rescue
{
    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    /**
     * @var array|string
     */
    public $os;

    public bool $active;

    public ?string $password = null;

    public array $authorizedKey = [];

    public array $hostKey = [];

    public static function fromArray(array $data): self
    {
        $rescue = new self;
        $rescue->serverIp = (string) ($data['server_ip'] ?? '');
        $rescue->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $rescue->serverNumber = (int) ($data['server_number'] ?? 0);
        $rescue->os = $data['os'] ?? [];
        $rescue->active = (bool) ($data['active'] ?? false);
        $rescue->password = isset($data['password']) ? (string) $data['password'] : null;
        $rescue->authorizedKey = (array) ($data['authorized_key'] ?? []);
        $rescue->hostKey = (array) ($data['host_key'] ?? []);

        return $rescue;
    }
}
