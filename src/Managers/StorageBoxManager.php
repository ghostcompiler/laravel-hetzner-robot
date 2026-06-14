<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\StorageBoxCollection;
use Vendor\HetznerRobot\DTOs\StorageBox;
use Vendor\HetznerRobot\DTOs\StorageBoxSnapshot;
use Vendor\HetznerRobot\DTOs\StorageBoxSnapshotPlan;
use Vendor\HetznerRobot\DTOs\StorageBoxSubAccount;

class StorageBoxManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('storagebox', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $boxes = array_map(function (array $item) {
                return StorageBox::fromArray($item['storagebox'] ?? []);
            }, $data);

            return new StorageBoxCollection($boxes);
        });
    }

    public function find(int $storageBoxId): mixed
    {
        $response = $this->getRequest("storagebox/{$storageBoxId}");

        return $this->hydrate($response, function (array $data) {
            return StorageBox::fromArray($data['storagebox'] ?? []);
        });
    }

    public function update(int $storageBoxId, array $data): mixed
    {
        $response = $this->postRequest("storagebox/{$storageBoxId}", $data);

        return $this->hydrate($response, function (array $data) {
            return StorageBox::fromArray($data['storagebox'] ?? []);
        });
    }

    public function updatePassword(int $storageBoxId, ?string $password = null): mixed
    {
        $data = [];
        if ($password !== null) {
            $data['password'] = $password;
        }

        $response = $this->postRequest("storagebox/{$storageBoxId}/password", $data);

        return $this->hydrate($response, function (array $data) {
            return StorageBox::fromArray($data['storagebox'] ?? []);
        });
    }

    // Snapshots
    public function getSnapshots(int $storageBoxId): mixed
    {
        $response = $this->getRequest("storagebox/{$storageBoxId}/snapshot");

        return $this->hydrate($response, function (array $data) {
            $snapshots = array_map(function (array $item) {
                return StorageBoxSnapshot::fromArray($item['snapshot'] ?? []);
            }, $data);

            return collect($snapshots);
        });
    }

    public function createSnapshot(int $storageBoxId): mixed
    {
        $response = $this->postRequest("storagebox/{$storageBoxId}/snapshot");

        return $this->hydrate($response, function (array $data) {
            return StorageBoxSnapshot::fromArray($data['snapshot'] ?? []);
        });
    }

    public function deleteSnapshot(int $storageBoxId, string $snapshotName): mixed
    {
        return $this->deleteRequest("storagebox/{$storageBoxId}/snapshot/{$snapshotName}");
    }

    public function revertToSnapshot(int $storageBoxId, string $snapshotName): mixed
    {
        return $this->postRequest("storagebox/{$storageBoxId}/snapshot/{$snapshotName}", ['revert' => 'true']);
    }

    public function updateSnapshotComment(int $storageBoxId, string $snapshotName, string $comment): mixed
    {
        return $this->postRequest("storagebox/{$storageBoxId}/snapshot/{$snapshotName}/comment", ['comment' => $comment]);
    }

    // Snapshot Plan
    public function getSnapshotPlan(int $storageBoxId): mixed
    {
        $response = $this->getRequest("storagebox/{$storageBoxId}/snapshotplan");

        return $this->hydrate($response, function (array $data) {
            // Plan response comes wrapped as an array containing an object with a snapshotplan key
            $first = $data[0] ?? $data;

            return StorageBoxSnapshotPlan::fromArray($first['snapshotplan'] ?? $first);
        });
    }

    public function updateSnapshotPlan(int $storageBoxId, array $data): mixed
    {
        $response = $this->postRequest("storagebox/{$storageBoxId}/snapshotplan", $data);

        return $this->hydrate($response, function (array $data) {
            $first = $data[0] ?? $data;

            return StorageBoxSnapshotPlan::fromArray($first['snapshotplan'] ?? $first);
        });
    }

    // Sub-accounts
    public function getSubAccounts(int $storageBoxId): mixed
    {
        $response = $this->getRequest("storagebox/{$storageBoxId}/subaccount");

        return $this->hydrate($response, function (array $data) {
            $subs = array_map(function (array $item) {
                return StorageBoxSubAccount::fromArray($item['subaccount'] ?? []);
            }, $data);

            return collect($subs);
        });
    }

    public function createSubAccount(int $storageBoxId, array $data): mixed
    {
        $response = $this->postRequest("storagebox/{$storageBoxId}/subaccount", $data);

        return $this->hydrate($response, function (array $data) {
            return StorageBoxSubAccount::fromArray($data['subaccount'] ?? []);
        });
    }

    public function updateSubAccount(int $storageBoxId, string $username, array $data): mixed
    {
        $response = $this->putRequest("storagebox/{$storageBoxId}/subaccount/{$username}", $data);

        return $this->hydrate($response, function (array $data) {
            return StorageBoxSubAccount::fromArray($data['subaccount'] ?? []);
        });
    }

    public function deleteSubAccount(int $storageBoxId, string $username): mixed
    {
        return $this->deleteRequest("storagebox/{$storageBoxId}/subaccount/{$username}");
    }

    public function updateSubAccountPassword(int $storageBoxId, string $username, ?string $password = null): mixed
    {
        $data = [];
        if ($password !== null) {
            $data['password'] = $password;
        }

        $response = $this->postRequest("storagebox/{$storageBoxId}/subaccount/{$username}/password", $data);

        return $this->hydrate($response, function (array $data) {
            return StorageBoxSubAccount::fromArray($data['subaccount'] ?? []);
        });
    }
}
