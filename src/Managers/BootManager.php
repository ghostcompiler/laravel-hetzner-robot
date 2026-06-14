<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\DTOs\Boot;
use Vendor\HetznerRobot\DTOs\Linux;
use Vendor\HetznerRobot\DTOs\Rescue;
use Vendor\HetznerRobot\DTOs\Vnc;
use Vendor\HetznerRobot\DTOs\Windows;

class BootManager extends AbstractManager
{
    public function find(int $serverNumber): mixed
    {
        $response = $this->getRequest("boot/{$serverNumber}");

        return $this->hydrate($response, function (array $data) {
            return Boot::fromArray($data['boot'] ?? []);
        });
    }

    // Rescue config
    public function getRescue(int $serverNumber): mixed
    {
        $response = $this->getRequest("boot/{$serverNumber}/rescue");

        return $this->hydrate($response, function (array $data) {
            return Rescue::fromArray($data['rescue'] ?? []);
        });
    }

    public function enableRescue(int $serverNumber, array $data): mixed
    {
        $response = $this->postRequest("boot/{$serverNumber}/rescue", $data);

        return $this->hydrate($response, function (array $data) {
            return Rescue::fromArray($data['rescue'] ?? []);
        });
    }

    public function disableRescue(int $serverNumber): mixed
    {
        $response = $this->deleteRequest("boot/{$serverNumber}/rescue");

        return $this->hydrate($response, function (array $data) {
            return Rescue::fromArray($data['rescue'] ?? []);
        });
    }

    public function getLastRescue(int $serverNumber): mixed
    {
        $response = $this->getRequest("boot/{$serverNumber}/rescue/last");

        return $this->hydrate($response, function (array $data) {
            return Rescue::fromArray($data['rescue'] ?? []);
        });
    }

    // Linux config
    public function getLinux(int $serverNumber): mixed
    {
        $response = $this->getRequest("boot/{$serverNumber}/linux");

        return $this->hydrate($response, function (array $data) {
            return Linux::fromArray($data['linux'] ?? []);
        });
    }

    public function enableLinux(int $serverNumber, array $data): mixed
    {
        $response = $this->postRequest("boot/{$serverNumber}/linux", $data);

        return $this->hydrate($response, function (array $data) {
            return Linux::fromArray($data['linux'] ?? []);
        });
    }

    public function disableLinux(int $serverNumber): mixed
    {
        $response = $this->deleteRequest("boot/{$serverNumber}/linux");

        return $this->hydrate($response, function (array $data) {
            return Linux::fromArray($data['linux'] ?? []);
        });
    }

    public function getLastLinux(int $serverNumber): mixed
    {
        $response = $this->getRequest("boot/{$serverNumber}/linux/last");

        return $this->hydrate($response, function (array $data) {
            return Linux::fromArray($data['linux'] ?? []);
        });
    }

    // Vnc config
    public function getVnc(int $serverNumber): mixed
    {
        $response = $this->getRequest("boot/{$serverNumber}/vnc");

        return $this->hydrate($response, function (array $data) {
            return Vnc::fromArray($data['vnc'] ?? []);
        });
    }

    public function enableVnc(int $serverNumber, array $data): mixed
    {
        $response = $this->postRequest("boot/{$serverNumber}/vnc", $data);

        return $this->hydrate($response, function (array $data) {
            return Vnc::fromArray($data['vnc'] ?? []);
        });
    }

    public function disableVnc(int $serverNumber): mixed
    {
        $response = $this->deleteRequest("boot/{$serverNumber}/vnc");

        return $this->hydrate($response, function (array $data) {
            return Vnc::fromArray($data['vnc'] ?? []);
        });
    }

    // Windows config
    public function getWindows(int $serverNumber): mixed
    {
        $response = $this->getRequest("boot/{$serverNumber}/windows");

        return $this->hydrate($response, function (array $data) {
            return Windows::fromArray($data['windows'] ?? []);
        });
    }

    public function enableWindows(int $serverNumber, array $data): mixed
    {
        $response = $this->postRequest("boot/{$serverNumber}/windows", $data);

        return $this->hydrate($response, function (array $data) {
            return Windows::fromArray($data['windows'] ?? []);
        });
    }

    public function disableWindows(int $serverNumber): mixed
    {
        $response = $this->deleteRequest("boot/{$serverNumber}/windows");

        return $this->hydrate($response, function (array $data) {
            return Windows::fromArray($data['windows'] ?? []);
        });
    }
}
