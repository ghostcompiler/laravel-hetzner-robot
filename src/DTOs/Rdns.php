<?php

namespace Vendor\HetznerRobot\DTOs;

class Rdns
{
    public string $ip;

    public string $ptr;

    public static function fromArray(array $data): self
    {
        $rdns = new self;
        $rdns->ip = (string) ($data['ip'] ?? '');
        $rdns->ptr = (string) ($data['ptr'] ?? '');

        return $rdns;
    }
}
