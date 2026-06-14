<?php

namespace Vendor\HetznerRobot\DTOs;

class Traffic
{
    public string $type;

    public string $from;

    public string $to;

    public array $data = [];

    public static function fromArray(array $data): self
    {
        $traffic = new self;
        $traffic->type = (string) ($data['type'] ?? '');
        $traffic->from = (string) ($data['from'] ?? '');
        $traffic->to = (string) ($data['to'] ?? '');
        $traffic->data = (array) ($data['data'] ?? []);

        return $traffic;
    }
}
