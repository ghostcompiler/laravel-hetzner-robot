<?php

namespace Vendor\HetznerRobot\DTOs;

class ServerCancellation
{
    public string $serverIp;

    public string $serverIpv6Net;

    public int $serverNumber;

    public string $serverName;

    public string $earliestCancellationDate;

    public bool $cancelled;

    public bool $reservationPossible;

    public bool $reserved;

    public ?string $cancellationDate = null;

    /**
     * @var array|string|null
     */
    public $cancellationReason = null;

    public static function fromArray(array $data): self
    {
        $cancellation = new self;
        $cancellation->serverIp = (string) ($data['server_ip'] ?? '');
        $cancellation->serverIpv6Net = (string) ($data['server_ipv6_net'] ?? '');
        $cancellation->serverNumber = (int) ($data['server_number'] ?? 0);
        $cancellation->serverName = (string) ($data['server_name'] ?? '');
        $cancellation->earliestCancellationDate = (string) ($data['earliest_cancellation_date'] ?? '');
        $cancellation->cancelled = (bool) ($data['cancelled'] ?? false);
        $cancellation->reservationPossible = (bool) ($data['reservation_possible'] ?? false);
        $cancellation->reserved = (bool) ($data['reserved'] ?? $data['reservation'] ?? false);
        $cancellation->cancellationDate = $data['cancellation_date'] ?? $data['cancellation-date'] ?? null;
        $cancellation->cancellationReason = $data['cancellation_reason'] ?? null;

        return $cancellation;
    }
}
