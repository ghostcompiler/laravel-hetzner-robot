<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\ServerCollection;
use Vendor\HetznerRobot\DTOs\Server;
use Vendor\HetznerRobot\DTOs\ServerCancellation;

class ServerManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('server', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $servers = array_map(function (array $item) {
                return Server::fromArray($item['server'] ?? []);
            }, $data);

            return new ServerCollection($servers);
        });
    }

    public function find(int $serverNumber): mixed
    {
        $response = $this->getRequest("server/{$serverNumber}");

        return $this->hydrate($response, function (array $data) {
            return Server::fromArray($data['server'] ?? []);
        });
    }

    public function update(int $serverNumber, array $data): mixed
    {
        $response = $this->postRequest("server/{$serverNumber}", $data);

        return $this->hydrate($response, function (array $data) {
            return Server::fromArray($data['server'] ?? []);
        });
    }

    public function getCancellation(int $serverNumber): mixed
    {
        $response = $this->getRequest("server/{$serverNumber}/cancellation");

        return $this->hydrate($response, function (array $data) {
            return ServerCancellation::fromArray($data['cancellation'] ?? []);
        });
    }

    public function createCancellation(int $serverNumber, array $data): mixed
    {
        $response = $this->postRequest("server/{$serverNumber}/cancellation", $data);

        return $this->hydrate($response, function (array $data) {
            return ServerCancellation::fromArray($data['cancellation'] ?? []);
        });
    }

    public function deleteCancellation(int $serverNumber): mixed
    {
        $response = $this->deleteRequest("server/{$serverNumber}/cancellation");

        return $this->hydrate($response, function (array $data) {
            return ServerCancellation::fromArray($data['cancellation'] ?? []);
        });
    }
}
