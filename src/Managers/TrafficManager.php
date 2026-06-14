<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\DTOs\Traffic;

class TrafficManager extends AbstractManager
{
    public function query(array $data): mixed
    {
        $response = $this->postRequest('traffic', $data);

        return $this->hydrate($response, function (array $data) {
            return Traffic::fromArray($data['traffic'] ?? []);
        });
    }
}
