<?php

namespace Vendor\HetznerRobot\DTOs;

class SshKey
{
    public string $name;

    public string $fingerprint;

    public string $type;

    public int $size;

    public string $data;

    public string $createdAt;

    public static function fromArray(array $data): self
    {
        $key = new self;
        $key->name = (string) ($data['name'] ?? '');
        $key->fingerprint = (string) ($data['fingerprint'] ?? '');
        $key->type = (string) ($data['type'] ?? '');
        $key->size = (int) ($data['size'] ?? 0);
        $key->data = (string) ($data['data'] ?? '');
        $key->createdAt = (string) ($data['created_at'] ?? '');

        return $key;
    }
}
