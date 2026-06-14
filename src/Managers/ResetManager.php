<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\ResetCollection;
use Vendor\HetznerRobot\DTOs\Reset;

class ResetManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('reset', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $resets = array_map(function (array $item) {
                return Reset::fromArray($item['reset'] ?? []);
            }, $data);

            return new ResetCollection($resets);
        });
    }

    public function find(int $serverNumber): mixed
    {
        $response = $this->getRequest("reset/{$serverNumber}");

        return $this->hydrate($response, function (array $data) {
            return Reset::fromArray($data['reset'] ?? []);
        });
    }

    public function create(int $serverNumber, array $data): mixed
    {
        $response = $this->postRequest("reset/{$serverNumber}", $data);

        return $this->hydrate($response, function (array $data) {
            return Reset::fromArray($data['reset'] ?? []);
        });
    }
}
