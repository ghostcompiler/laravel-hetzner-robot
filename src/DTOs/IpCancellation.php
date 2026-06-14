<?php

namespace Vendor\HetznerRobot\DTOs;

class IpCancellation
{
    public string $ip;

    public int $serverNumber;

    public string $earliestCancellationDate;

    public bool $cancelled;

    public ?string $cancellationDate = null;

    public static function fromArray(array $data): self
    {
        $cancellation = new self;
        $cancellation->ip = (string) ($data['ip'] ?? '');
        $cancellation->serverNumber = (int) ($data['server_number'] ?? 0);
        $cancellation->earliestCancellationDate = (string) ($data['earliest_cancellation_date'] ?? '');
        $cancellation->cancelled = (bool) ($data['cancelled'] ?? false);
        $cancellation->cancellationDate = $data['cancellation_date'] ?? $data['cancellation-date'] ?? null;

        return $cancellation;
    }
}
