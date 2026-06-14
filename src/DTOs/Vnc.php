<?php

namespace Vendor\HetznerRobot\DTOs;

class Vnc
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

    public static function fromArray(array $data): self
    {
        $vnc = new self;
        $vnc->serverIp = (string) ($data['server_ip'] ?? '');
        $vnc->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $vnc->serverNumber = (int) ($data['server_number'] ?? 0);
        $vnc->dist = $data['dist'] ?? [];
        $vnc->lang = $data['lang'] ?? [];
        $vnc->active = (bool) ($data['active'] ?? false);
        $vnc->password = isset($data['password']) ? (string) $data['password'] : null;

        return $vnc;
    }
}
