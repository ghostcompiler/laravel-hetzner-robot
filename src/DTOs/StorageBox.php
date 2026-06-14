<?php

namespace Vendor\HetznerRobot\DTOs;

class StorageBox
{
    public int $id;

    public string $login;

    public string $name;

    public string $product;

    public bool $cancelled;

    public bool $locked;

    public string $location;

    public ?int $linkedServer = null;

    public string $paidUntil;

    public int $diskQuota;

    public int $diskUsage;

    public int $diskUsageData;

    public int $diskUsageSnapshots;

    public bool $webdav;

    public bool $samba;

    public bool $ssh;

    public bool $externalReachability;

    public bool $zfs;

    public string $server;

    public string $hostSystem;

    public static function fromArray(array $data): self
    {
        $box = new self;
        $box->id = (int) ($data['id'] ?? 0);
        $box->login = (string) ($data['login'] ?? '');
        $box->name = (string) ($data['name'] ?? '');
        $box->product = (string) ($data['product'] ?? '');
        $box->cancelled = (bool) ($data['cancelled'] ?? false);
        $box->locked = (bool) ($data['locked'] ?? false);
        $box->location = (string) ($data['location'] ?? '');
        $box->linkedServer = isset($data['linked_server']) ? (int) $data['linked_server'] : null;
        $box->paidUntil = (string) ($data['paid_until'] ?? '');
        $box->diskQuota = (int) ($data['disk_quota'] ?? 0);
        $box->diskUsage = (int) ($data['disk_usage'] ?? 0);
        $box->diskUsageData = (int) ($data['disk_usage_data'] ?? 0);
        $box->diskUsageSnapshots = (int) ($data['disk_usage_snapshots'] ?? 0);
        $box->webdav = (bool) ($data['webdav'] ?? false);
        $box->samba = (bool) ($data['samba'] ?? false);
        $box->ssh = (bool) ($data['ssh'] ?? false);
        $box->externalReachability = (bool) ($data['external_reachability'] ?? false);
        $box->zfs = (bool) ($data['zfs'] ?? false);
        $box->server = (string) ($data['server'] ?? '');
        $box->hostSystem = (string) ($data['host_system'] ?? '');

        return $box;
    }
}
