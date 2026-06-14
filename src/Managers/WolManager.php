<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\DTOs\Wol;

class WolManager extends AbstractManager
{
    public function find(int $serverNumber): mixed
    {
        $response = $this->getRequest("wol/{$serverNumber}");

        return $this->hydrate($response, function (array $data) {
            return Wol::fromArray($data['wol'] ?? []);
        });
    }

    public function send(int $serverNumber): mixed
    {
        $response = $this->postRequest("wol/{$serverNumber}");

        return $this->hydrate($response, function (array $data) {
            return Wol::fromArray($data['wol'] ?? []);
        });
    }
}
