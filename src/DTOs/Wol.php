<?php

namespace Vendor\HetznerRobot\DTOs;

class Wol
{
    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    public static function fromArray(array $data): self
    {
        $wol = new self;
        $wol->serverIp = (string) ($data['server_ip'] ?? '');
        $wol->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $wol->serverNumber = (int) ($data['server_number'] ?? 0);

        return $wol;
    }
}
