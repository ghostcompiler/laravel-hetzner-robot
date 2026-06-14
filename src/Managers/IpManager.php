<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\IpCollection;
use Vendor\HetznerRobot\DTOs\Ip;
use Vendor\HetznerRobot\DTOs\IpCancellation;
use Vendor\HetznerRobot\DTOs\Mac;

class IpManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('ip', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $ips = array_map(function (array $item) {
                return Ip::fromArray($item['ip'] ?? []);
            }, $data);

            return new IpCollection($ips);
        });
    }

    public function find(string $ip): mixed
    {
        $response = $this->getRequest("ip/{$ip}");

        return $this->hydrate($response, function (array $data) {
            return Ip::fromArray($data['ip'] ?? []);
        });
    }

    public function update(string $ip, array $data): mixed
    {
        $response = $this->postRequest("ip/{$ip}", $data);

        return $this->hydrate($response, function (array $data) {
            return Ip::fromArray($data['ip'] ?? []);
        });
    }

    public function getMac(string $ip): mixed
    {
        $response = $this->getRequest("ip/{$ip}/mac");

        return $this->hydrate($response, function (array $data) {
            return Mac::fromArray($data['mac'] ?? []);
        });
    }

    public function updateMac(string $ip, string $mac): mixed
    {
        $response = $this->putRequest("ip/{$ip}/mac", ['mac' => $mac]);

        return $this->hydrate($response, function (array $data) {
            return Mac::fromArray($data['mac'] ?? []);
        });
    }

    public function deleteMac(string $ip): mixed
    {
        $response = $this->deleteRequest("ip/{$ip}/mac");

        return $this->hydrate($response, function (array $data) {
            return Mac::fromArray($data['mac'] ?? []);
        });
    }

    public function getCancellation(string $ip): mixed
    {
        $response = $this->getRequest("ip/{$ip}/cancellation");

        return $this->hydrate($response, function (array $data) {
            return IpCancellation::fromArray($data['cancellation'] ?? []);
        });
    }

    public function createCancellation(string $ip, array $data): mixed
    {
        $response = $this->postRequest("ip/{$ip}/cancellation", $data);

        return $this->hydrate($response, function (array $data) {
            return IpCancellation::fromArray($data['cancellation'] ?? []);
        });
    }

    public function deleteCancellation(string $ip): mixed
    {
        $response = $this->deleteRequest("ip/{$ip}/cancellation");

        return $this->hydrate($response, function (array $data) {
            return IpCancellation::fromArray($data['cancellation'] ?? []);
        });
    }
}
