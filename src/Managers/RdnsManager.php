<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\DTOs\Rdns;

class RdnsManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('rdns', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $records = array_map(function (array $item) {
                return Rdns::fromArray($item['rdns'] ?? []);
            }, $data);

            return collect($records);
        });
    }

    public function find(string $ip): mixed
    {
        $response = $this->getRequest("rdns/{$ip}");

        return $this->hydrate($response, function (array $data) {
            return Rdns::fromArray($data['rdns'] ?? []);
        });
    }

    public function create(string $ip, string $ptr): mixed
    {
        $response = $this->postRequest("rdns/{$ip}", ['ptr' => $ptr]);

        return $this->hydrate($response, function (array $data) {
            return Rdns::fromArray($data['rdns'] ?? []);
        });
    }

    public function update(string $ip, string $ptr): mixed
    {
        $response = $this->putRequest("rdns/{$ip}", ['ptr' => $ptr]);

        return $this->hydrate($response, function (array $data) {
            return Rdns::fromArray($data['rdns'] ?? []);
        });
    }

    public function delete(string $ip): mixed
    {
        return $this->deleteRequest("rdns/{$ip}");
    }
}
