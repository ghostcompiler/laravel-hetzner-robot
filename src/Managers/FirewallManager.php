<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\DTOs\Firewall;
use Vendor\HetznerRobot\DTOs\FirewallTemplate;

class FirewallManager extends AbstractManager
{
    public function find(int $serverId): mixed
    {
        $response = $this->getRequest("firewall/{$serverId}");

        return $this->hydrate($response, function (array $data) {
            return Firewall::fromArray($data['firewall'] ?? []);
        });
    }

    public function create(int $serverId, array $data): mixed
    {
        $response = $this->postRequest("firewall/{$serverId}", $data);

        return $this->hydrate($response, function (array $data) {
            return Firewall::fromArray($data['firewall'] ?? []);
        });
    }

    public function delete(int $serverId): mixed
    {
        return $this->deleteRequest("firewall/{$serverId}");
    }

    // Templates
    public function getTemplates(): mixed
    {
        $response = $this->getRequest('firewall/template');

        return $this->hydrate($response, function (array $data) {
            $templates = array_map(function (array $item) {
                return FirewallTemplate::fromArray($item['firewall_template'] ?? []);
            }, $data);

            return collect($templates);
        });
    }

    public function createTemplate(array $data): mixed
    {
        $response = $this->postRequest('firewall/template', $data);

        return $this->hydrate($response, function (array $data) {
            return FirewallTemplate::fromArray($data['firewall_template'] ?? []);
        });
    }

    public function getTemplate(int $templateId): mixed
    {
        $response = $this->getRequest("firewall/template/{$templateId}");

        return $this->hydrate($response, function (array $data) {
            return FirewallTemplate::fromArray($data['firewall_template'] ?? []);
        });
    }

    public function updateTemplate(int $templateId, array $data): mixed
    {
        $response = $this->postRequest("firewall/template/{$templateId}", $data);

        return $this->hydrate($response, function (array $data) {
            return FirewallTemplate::fromArray($data['firewall_template'] ?? []);
        });
    }

    public function deleteTemplate(int $templateId): mixed
    {
        return $this->deleteRequest("firewall/template/{$templateId}");
    }
}
