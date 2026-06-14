<?php

namespace Vendor\HetznerRobot\DTOs;

class StorageBoxSnapshotPlan
{
    public string $status;

    public ?int $minute = null;

    public ?int $hour = null;

    public ?int $dayOfWeek = null;

    public ?int $dayOfMonth = null;

    public ?int $month = null;

    public int $maxSnapshots;

    public static function fromArray(array $data): self
    {
        $plan = new self;
        $plan->status = (string) ($data['status'] ?? '');
        $plan->minute = isset($data['minute']) ? (int) $data['minute'] : null;
        $plan->hour = isset($data['hour']) ? (int) $data['hour'] : null;
        $plan->dayOfWeek = isset($data['day_of_week']) ? (int) $data['day_of_week'] : null;
        $plan->dayOfMonth = isset($data['day_of_month']) ? (int) $data['day_of_month'] : null;
        $plan->month = isset($data['month']) ? (int) $data['month'] : null;
        $plan->maxSnapshots = (int) ($data['max_snapshots'] ?? 0);

        return $plan;
    }
}
