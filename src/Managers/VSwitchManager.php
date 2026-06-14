<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\VSwitchCollection;
use Vendor\HetznerRobot\DTOs\VSwitch;

class VSwitchManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('vswitch', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $vswitches = array_map(function (array $item) {
                // List of vswitches is returned directly as a flat list in GET /vswitch or is it wrapped?
                // Let's look at GET /vswitch output:
                // [ { "id": 1234, "name": "vswitch 1234", ... }, ... ]
                // It is NOT wrapped in a {"vswitch": ...} container!
                return VSwitch::fromArray($item);
            }, $data);

            return new VSwitchCollection($vswitches);
        });
    }

    public function create(array $data): mixed
    {
        $response = $this->postRequest('vswitch', $data);

        return $this->hydrate($response, function (array $data) {
            return VSwitch::fromArray($data);
        });
    }

    public function find(int $vswitchId): mixed
    {
        $response = $this->getRequest("vswitch/{$vswitchId}");

        return $this->hydrate($response, function (array $data) {
            return VSwitch::fromArray($data);
        });
    }

    public function update(int $vswitchId, array $data): mixed
    {
        $response = $this->postRequest("vswitch/{$vswitchId}", $data);

        return $this->hydrate($response, function (array $data) {
            // Note: GET /vswitch/{id} returns vSwitch info directly
            return VSwitch::fromArray($data);
        });
    }

    public function delete(int $vswitchId, string $date = 'now'): mixed
    {
        return $this->deleteRequest("vswitch/{$vswitchId}", ['cancellation_date' => $date]);
    }

    public function addServers(int $vswitchId, array $servers): mixed
    {
        return $this->postRequest("vswitch/{$vswitchId}/server", ['server' => $servers]);
    }

    public function removeServers(int $vswitchId, array $servers): mixed
    {
        return $this->deleteRequest("vswitch/{$vswitchId}/server", ['server' => $servers]);
    }
}
