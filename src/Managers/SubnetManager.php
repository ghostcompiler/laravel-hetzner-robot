<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\SubnetCollection;
use Vendor\HetznerRobot\DTOs\Mac;
use Vendor\HetznerRobot\DTOs\Subnet;
use Vendor\HetznerRobot\DTOs\SubnetCancellation;

class SubnetManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('subnet', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $subnets = array_map(function (array $item) {
                return Subnet::fromArray($item['subnet'] ?? []);
            }, $data);

            return new SubnetCollection($subnets);
        });
    }

    public function find(string $netIp): mixed
    {
        $response = $this->getRequest("subnet/{$netIp}");

        return $this->hydrate($response, function (array $data) {
            return Subnet::fromArray($data['subnet'] ?? []);
        });
    }

    public function update(string $netIp, array $data): mixed
    {
        $response = $this->postRequest("subnet/{$netIp}", $data);

        return $this->hydrate($response, function (array $data) {
            return Subnet::fromArray($data['subnet'] ?? []);
        });
    }

    public function getMac(string $netIp): mixed
    {
        $response = $this->getRequest("subnet/{$netIp}/mac");

        return $this->hydrate($response, function (array $data) {
            return Mac::fromArray($data['mac'] ?? []);
        });
    }

    public function updateMac(string $netIp, string $mac): mixed
    {
        $response = $this->putRequest("subnet/{$netIp}/mac", ['mac' => $mac]);

        return $this->hydrate($response, function (array $data) {
            return Mac::fromArray($data['mac'] ?? []);
        });
    }

    public function deleteMac(string $netIp): mixed
    {
        $response = $this->deleteRequest("subnet/{$netIp}/mac");

        return $this->hydrate($response, function (array $data) {
            return Mac::fromArray($data['mac'] ?? []);
        });
    }

    public function getCancellation(string $netIp): mixed
    {
        $response = $this->getRequest("subnet/{$netIp}/cancellation");

        return $this->hydrate($response, function (array $data) {
            return SubnetCancellation::fromArray($data['cancellation'] ?? []);
        });
    }

    public function createCancellation(string $netIp, array $data): mixed
    {
        $response = $this->postRequest("subnet/{$netIp}/cancellation", $data);

        return $this->hydrate($response, function (array $data) {
            return SubnetCancellation::fromArray($data['cancellation'] ?? []);
        });
    }

    public function deleteCancellation(string $netIp): mixed
    {
        // Note: API specifies endpoint as DELETE /subnet/{ip}/cancellation
        $response = $this->deleteRequest("subnet/{$netIp}/cancellation");

        return $this->hydrate($response, function (array $data) {
            return SubnetCancellation::fromArray($data['cancellation'] ?? []);
        });
    }
}
