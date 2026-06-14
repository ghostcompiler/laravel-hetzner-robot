<?php

namespace Vendor\HetznerRobot\DTOs;

class StorageBoxSubAccount
{
    public string $username;

    public string $accountId;

    public string $server;

    public string $homeDirectory;

    public bool $samba;

    public bool $ssh;

    public bool $externalReachability;

    public bool $webdav;

    public bool $readonly;

    public ?string $createTime = null;

    public ?string $comment = null;

    public ?string $password = null;

    public static function fromArray(array $data): self
    {
        $sub = new self;
        $sub->username = (string) ($data['username'] ?? '');
        $sub->accountId = (string) ($data['accountid'] ?? '');
        $sub->server = (string) ($data['server'] ?? '');
        $sub->homeDirectory = (string) ($data['homedirectory'] ?? '');
        $sub->samba = (bool) ($data['samba'] ?? false);
        $sub->ssh = (bool) ($data['ssh'] ?? false);
        $sub->externalReachability = (bool) ($data['external_reachability'] ?? false);
        $sub->webdav = (bool) ($data['webdav'] ?? false);
        $sub->readonly = (bool) ($data['readonly'] ?? false);
        $sub->createTime = $data['createtime'] ?? null;
        $sub->comment = $data['comment'] ?? null;
        $sub->password = $data['password'] ?? null;

        return $sub;
    }
}
