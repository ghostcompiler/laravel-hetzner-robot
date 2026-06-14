<?php

namespace Vendor\HetznerRobot\DTOs;

class Server
{
    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    public string $serverName;

    public string $product;

    public string $dc;

    public string $traffic;

    public string $status;

    public bool $cancelled;

    public string $paidUntil;

    public array $ip = [];

    public array $subnet = [];

    public ?bool $reset = null;

    public ?bool $rescue = null;

    public ?bool $vnc = null;

    public ?bool $windows = null;

    public ?bool $plesk = null;

    public ?bool $cpanel = null;

    public ?bool $wol = null;

    public ?bool $hotSwap = null;

    public ?int $linkedStoragebox = null;

    public static function fromArray(array $data): self
    {
        $server = new self;
        $server->serverIp = (string) ($data['server_ip'] ?? '');
        $server->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $server->serverNumber = (int) ($data['server_number'] ?? 0);
        $server->serverName = (string) ($data['server_name'] ?? '');
        $server->product = (string) ($data['product'] ?? '');
        $server->dc = (string) ($data['dc'] ?? '');
        $server->traffic = (string) ($data['traffic'] ?? '');
        $server->status = (string) ($data['status'] ?? '');
        $server->cancelled = (bool) ($data['cancelled'] ?? false);
        $server->paidUntil = (string) ($data['paid_until'] ?? '');
        $server->ip = (array) ($data['ip'] ?? []);
        $server->subnet = (array) ($data['subnet'] ?? []);
        $server->reset = isset($data['reset']) ? (bool) $data['reset'] : null;
        $server->rescue = isset($data['rescue']) ? (bool) $data['rescue'] : null;
        $server->vnc = isset($data['vnc']) ? (bool) $data['vnc'] : null;
        $server->windows = isset($data['windows']) ? (bool) $data['windows'] : null;
        $server->plesk = isset($data['plesk']) ? (bool) $data['plesk'] : null;
        $server->cpanel = isset($data['cpanel']) ? (bool) $data['cpanel'] : null;
        $server->wol = isset($data['wol']) ? (bool) $data['wol'] : null;
        $server->hotSwap = isset($data['hot_swap']) ? (bool) $data['hot_swap'] : null;
        $server->linkedStoragebox = isset($data['linked_storagebox']) ? (int) $data['linked_storagebox'] : null;

        return $server;
    }
}
