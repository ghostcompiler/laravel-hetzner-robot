<?php

namespace Vendor\HetznerRobot\DTOs;

class OrderTransaction
{
    public string $id;

    public string $date;

    public string $status;

    public ?int $serverNumber = null;

    public ?string $serverIp = null;

    public array $authorizedKey = [];

    public array $hostKey = [];

    public ?string $comment = null;

    /**
     * @var array|null
     */
    public $product = null;

    public array $addons = [];

    public static function fromArray(array $data): self
    {
        $transaction = new self;
        $transaction->id = (string) ($data['id'] ?? '');
        $transaction->date = (string) ($data['date'] ?? '');
        $transaction->status = (string) ($data['status'] ?? '');
        $transaction->serverNumber = isset($data['server_number']) ? (int) $data['server_number'] : null;
        $transaction->serverIp = isset($data['server_ip']) ? (string) $data['server_ip'] : null;
        $transaction->authorizedKey = (array) ($data['authorized_key'] ?? []);
        $transaction->hostKey = (array) ($data['host_key'] ?? []);
        $transaction->comment = isset($data['comment']) ? (string) $data['comment'] : null;
        $transaction->product = isset($data['product']) ? (array) $data['product'] : null;
        $transaction->addons = (array) ($data['addons'] ?? []);

        return $transaction;
    }
}
