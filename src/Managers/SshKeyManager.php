<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\Collections\SshKeyCollection;
use Vendor\HetznerRobot\DTOs\SshKey;

class SshKeyManager extends AbstractManager
{
    public function all(): mixed
    {
        $response = $this->getRequest('key', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $keys = array_map(function (array $item) {
                return SshKey::fromArray($item['key'] ?? []);
            }, $data);

            return new SshKeyCollection($keys);
        });
    }

    public function find(string $fingerprint): mixed
    {
        $response = $this->getRequest("key/{$fingerprint}");

        return $this->hydrate($response, function (array $data) {
            return SshKey::fromArray($data['key'] ?? []);
        });
    }

    public function create(array $data): mixed
    {
        $response = $this->postRequest('key', $data);

        return $this->hydrate($response, function (array $data) {
            return SshKey::fromArray($data['key'] ?? []);
        });
    }

    public function update(string $fingerprint, array $data): mixed
    {
        $response = $this->postRequest("key/{$fingerprint}", $data);

        return $this->hydrate($response, function (array $data) {
            return SshKey::fromArray($data['key'] ?? []);
        });
    }

    public function delete(string $fingerprint): mixed
    {
        return $this->deleteRequest("key/{$fingerprint}");
    }
}
