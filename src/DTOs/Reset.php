<?php

namespace Vendor\HetznerRobot\DTOs;

class Reset
{
    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    /**
     * @var array|string
     */
    public $type;

    public ?string $operatingStatus = null;

    public static function fromArray(array $data): self
    {
        $reset = new self;
        $reset->serverIp = (string) ($data['server_ip'] ?? '');
        $reset->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $reset->serverNumber = (int) ($data['server_number'] ?? 0);
        $reset->type = $data['type'] ?? [];
        $reset->operatingStatus = isset($data['operating_status']) ? (string) $data['operating_status'] : null;

        return $reset;
    }
}
