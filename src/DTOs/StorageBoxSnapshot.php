<?php

namespace Vendor\HetznerRobot\DTOs;

class StorageBoxSnapshot
{
    public string $name;

    public string $timestamp;

    public int $size;

    public ?int $filesystemSize = null;

    public ?bool $automatic = null;

    public ?string $comment = null;

    public static function fromArray(array $data): self
    {
        $snapshot = new self;
        $snapshot->name = (string) ($data['name'] ?? '');
        $snapshot->timestamp = (string) ($data['timestamp'] ?? '');
        $snapshot->size = (int) ($data['size'] ?? 0);
        $snapshot->filesystemSize = isset($data['filesystem_size']) ? (int) $data['filesystem_size'] : null;
        $snapshot->automatic = isset($data['automatic']) ? (bool) $data['automatic'] : null;
        $snapshot->comment = isset($data['comment']) ? (string) $data['comment'] : null;

        return $snapshot;
    }
}
