<?php

namespace Vendor\HetznerRobot\Managers;

use GuzzleHttp\Promise\Utils;
use Vendor\HetznerRobot\Http\Client\HetznerClient;

class HetznerManager
{
    private HetznerClient $client;

    private array $managers = [];

    public function __construct(HetznerClient $client)
    {
        $this->client = $client;
    }

    public function authenticate(string $username, string $password): self
    {
        $this->client->authenticate($username, $password);

        return $this;
    }

    public function client(): HetznerClient
    {
        return $this->client;
    }

    public function version(): string
    {
        $path = __DIR__.'/../../composer.json';
        if (file_exists($path)) {
            $composer = json_decode(file_get_contents($path), true);

            return $composer['version'] ?? '1.0.0';
        }

        return '1.0.0';
    }

    public function config(): array
    {
        if (function_exists('config')) {
            return config('hetzner-robot') ?: [];
        }

        return [];
    }

    public function rateLimit(): array
    {
        return $this->client->getLastRateLimit();
    }

    public function ping(): bool
    {
        try {
            // Pinging the `/server` endpoint is standard for Robot Webservice
            $this->servers()->all();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function health(): array
    {
        $start = microtime(true);
        $ping = $this->ping();
        $latency = (int) ((microtime(true) - $start) * 1000);

        return [
            'status' => $ping ? 'healthy' : 'unhealthy',
            'latency_ms' => $latency,
            'timestamp' => time(),
        ];
    }

    /**
     * Run multiple SDK requests concurrently.
     */
    public function batch(array $callbacks): array
    {
        $this->client->startBatch();

        $callbackPromises = [];
        foreach ($callbacks as $callback) {
            $callbackPromises[] = $callback();
        }

        $this->client->endBatch();

        if (empty($callbackPromises)) {
            return [];
        }

        return Utils::all($callbackPromises)->wait();
    }

    public function servers(): ServerManager
    {
        return $this->getManager(ServerManager::class);
    }

    public function ips(): IpManager
    {
        return $this->getManager(IpManager::class);
    }

    public function subnets(): SubnetManager
    {
        return $this->getManager(SubnetManager::class);
    }

    public function resets(): ResetManager
    {
        return $this->getManager(ResetManager::class);
    }

    public function failovers(): FailoverManager
    {
        return $this->getManager(FailoverManager::class);
    }

    public function wols(): WolManager
    {
        return $this->getManager(WolManager::class);
    }

    public function boots(): BootManager
    {
        return $this->getManager(BootManager::class);
    }

    public function rdns(): RdnsManager
    {
        return $this->getManager(RdnsManager::class);
    }

    public function traffic(): TrafficManager
    {
        return $this->getManager(TrafficManager::class);
    }

    public function sshKeys(): SshKeyManager
    {
        return $this->getManager(SshKeyManager::class);
    }

    public function orders(): OrderManager
    {
        return $this->getManager(OrderManager::class);
    }

    public function storageBoxes(): StorageBoxManager
    {
        return $this->getManager(StorageBoxManager::class);
    }

    public function firewalls(): FirewallManager
    {
        return $this->getManager(FirewallManager::class);
    }

    public function vswitches(): VSwitchManager
    {
        return $this->getManager(VSwitchManager::class);
    }

    /**
     * Lazy instantiate and cache managers.
     */
    private function getManager(string $class)
    {
        if (! isset($this->managers[$class])) {
            $this->managers[$class] = new $class($this->client);
        }

        return $this->managers[$class];
    }
}
