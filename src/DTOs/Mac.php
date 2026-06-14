<?php

namespace Vendor\HetznerRobot\DTOs;

class Mac
{
    public string $ip;

    public ?string $mask = null;

    public ?string $mac = null;

    public array $possibleMac = [];

    public static function fromArray(array $data): self
    {
        $macObj = new self;
        $macObj->ip = (string) ($data['ip'] ?? '');
        $macObj->mask = isset($data['mask']) ? (string) $data['mask'] : null;
        $macObj->mac = isset($data['mac']) ? (string) $data['mac'] : null;
        $macObj->possibleMac = (array) ($data['possible_mac'] ?? []);

        return $macObj;
    }
}
