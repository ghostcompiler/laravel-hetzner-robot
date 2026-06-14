<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\FailoverCollection;
use Vendor\HetznerRobot\DTOs\Failover;

class FailoverManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('failover', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $failovers = array_map(function (array $item) {
                return Failover::fromArray($item['failover'] ?? []);
            }, $data);

            return new FailoverCollection($failovers);
        });
    }

    public function find(string $failoverIp): mixed
    {
        $response = $this->getRequest("failover/{$failoverIp}");

        return $this->hydrate($response, function (array $data) {
            return Failover::fromArray($data['failover'] ?? []);
        });
    }

    public function update(string $failoverIp, string $activeServerIp): mixed
    {
        $response = $this->postRequest("failover/{$failoverIp}", ['active_server_ip' => $activeServerIp]);

        return $this->hydrate($response, function (array $data) {
            return Failover::fromArray($data['failover'] ?? []);
        });
    }

    public function delete(string $failoverIp): mixed
    {
        $response = $this->deleteRequest("failover/{$failoverIp}");

        return $this->hydrate($response, function (array $data) {
            return Failover::fromArray($data['failover'] ?? []);
        });
    }
}
