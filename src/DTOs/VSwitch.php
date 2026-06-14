<?php

namespace Vendor\HetznerRobot\DTOs;

class VSwitch
{
    public int $id;

    public string $name;

    public int $vlan;

    public bool $cancelled;

    public array $server = [];

    public array $subnet = [];

    public array $cloudNetwork = [];

    public static function fromArray(array $data): self
    {
        $vswitch = new self;
        $vswitch->id = (int) ($data['id'] ?? 0);
        $vswitch->name = (string) ($data['name'] ?? '');
        $vswitch->vlan = (int) ($data['vlan'] ?? 0);
        $vswitch->cancelled = (bool) ($data['cancelled'] ?? false);
        $vswitch->server = (array) ($data['server'] ?? []);
        $vswitch->subnet = (array) ($data['subnet'] ?? []);
        $vswitch->cloudNetwork = (array) ($data['cloud_network'] ?? []);

        return $vswitch;
    }
}
