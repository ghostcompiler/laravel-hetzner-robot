<?php

namespace Vendor\HetznerRobot\DTOs;

class Boot
{
    public Rescue $rescue;

    public Linux $linux;

    public Vnc $vnc;

    public Windows $windows;

    public static function fromArray(array $data): self
    {
        $boot = new self;
        $boot->rescue = Rescue::fromArray($data['rescue'] ?? []);
        $boot->linux = Linux::fromArray($data['linux'] ?? []);
        $boot->vnc = Vnc::fromArray($data['vnc'] ?? []);
        $boot->windows = Windows::fromArray($data['windows'] ?? []);

        return $boot;
    }
}
