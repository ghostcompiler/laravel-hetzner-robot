<?php

namespace Vendor\HetznerRobot\DTOs;

class Windows
{
    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    /**
     * @var array|string
     */
    public $os;

    /**
     * @var array|string|null
     */
    public $lang;

    public bool $active;

    public ?string $password = null;

    public static function fromArray(array $data): self
    {
        $windows = new self;
        $windows->serverIp = (string) ($data['server_ip'] ?? '');
        $windows->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $windows->serverNumber = (int) ($data['server_number'] ?? 0);
        $windows->os = $data['os'] ?? [];
        $windows->lang = $data['lang'] ?? null;
        $windows->active = (bool) ($data['active'] ?? false);
        $windows->password = isset($data['password']) ? (string) $data['password'] : null;

        return $windows;
    }
}
