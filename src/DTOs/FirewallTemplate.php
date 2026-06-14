<?php

namespace Vendor\HetznerRobot\DTOs;

class FirewallTemplate
{
    public int $id;

    public string $name;

    public bool $filterIpv6;

    public bool $whitelistHos;

    public bool $isDefault;

    public array $rules = [];

    public static function fromArray(array $data): self
    {
        $template = new self;
        $template->id = (int) ($data['id'] ?? 0);
        $template->name = (string) ($data['name'] ?? '');
        $template->filterIpv6 = (bool) ($data['filter_ipv6'] ?? false);
        $template->whitelistHos = (bool) ($data['whitelist_hos'] ?? false);
        $template->isDefault = (bool) ($data['is_default'] ?? false);
        $template->rules = (array) ($data['rules'] ?? []);

        return $template;
    }
}
