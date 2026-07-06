<p align="center">
  <img src="https://res.cloudinary.com/djgvfl1tv/image/upload/v1780666791/logo_mqnqn4.png" alt="Laravel Hetzner Robot" width="180">
</p>

<h1 align="center">Laravel Hetzner Robot SDK</h1>

<p align="center">
  A premium, feature-rich PHP SDK and Laravel integration for the Hetzner Robot Web Service API, featuring rate-limit handling, automatic retries, and concurrent batch operations.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11%20%7C%2012%20%7C%2013-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2%20to%208.5-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Hetzner--Robot-API-D85012?style=for-the-badge" alt="Hetzner Robot API">
  <img src="https://img.shields.io/badge/Built%20By-Ghost%20Compiler-0F172A?style=for-the-badge" alt="Ghost Compiler">
</p>

<p align="center">
    <img src="https://img.shields.io/github/stars/ghostcompiler/laravel-hetzner-robot?style=for-the-badge&logo=github" />
    <img src="https://img.shields.io/packagist/dt/ghostcompiler/laravel-hetzner-robot?style=for-the-badge&logo=packagist" />
</p>

---

## Features

- **100% Endpoint Coverage**: Complete implementation of all 14 Robot webservice sections (servers, IPs, subnets, resets, failover, Wake-on-LAN, boot options, reverse DNS, traffic, SSH keys, order products, Storage Boxes, firewalls, and vSwitches).
- **Basic Authentication**: Fully automated Basic Auth headers configuration.
- **Form Urlencoded Requests**: Parameters transfer mapped automatically using `application/x-www-form-urlencoded`.
- **Fail-Safe Retries & Backoff**: Robust exponential backoff and rate-limit parsing handling `RATE_LIMIT_EXCEEDED` errors automatically.
- **Concurrently Pooled Processing**: Execute calls asynchronously or concurrently in batches.
- **Type-Safe DTOs**: Automated data hydration into standard PHP DTO structures.
- **Custom Exceptions**: Specialized mapping of API status codes (ValidationException, RateLimitException, AuthenticationException, etc.).

---

## Installation

Install the package via Composer:

```bash
composer require ghostcompiler/laravel-hetzner-robot
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Vendor\HetznerRobot\Providers\HetznerRobotServiceProvider" --tag="config"
```

Add your Hetzner Robot API Web Service credentials to your `.env` file:

```env
HETZNER_ROBOT_USERNAME=your_web_service_username_here
HETZNER_ROBOT_PASSWORD=your_web_service_password_here
HETZNER_ROBOT_BASE_URL=https://robot-ws.your-server.de
HETZNER_ROBOT_TIMEOUT=30
HETZNER_ROBOT_RETRIES=3
HETZNER_ROBOT_LOGGING_ENABLED=true
```

---

## Usage Examples

### Servers

#### Listing and Finding Servers
```php
use Vendor\HetznerRobot\Facades\HetznerRobot;

// List all servers
$servers = HetznerRobot::servers()->all();

foreach ($servers as $server) {
    echo $server->serverName . ': ' . $server->serverIp . "\n";
}

// Find a server by number
$server = HetznerRobot::servers()->find(321);
echo "DC: " . $server->dc;
```

#### Updating and Cancelling a Server
```php
// Rename a server
$server = HetznerRobot::servers()->update(321, [
    'server_name' => 'production-web-01'
]);

// Cancel a server
$cancellation = HetznerRobot::servers()->createCancellation(321, [
    'cancellation_reason' => 'no_longer_needed'
]);
echo "Cancellation status: " . $cancellation->cancellationDate;
```

---

### IP & Subnet Management
```php
// List all IP addresses
$ips = HetznerRobot::ips()->all();

// Update reverse DNS (PTR)
$rdns = HetznerRobot::rdns()->create('123.123.123.123', 'your-domain.com');

// Enable MAC address for IP
$mac = HetznerRobot::ips()->updateMac('123.123.123.123', '00:11:22:33:44:55');
```

---

### Boot Configurations (Rescue, Linux, Windows, VNC)
```php
// Enable rescue system for server
$rescue = HetznerRobot::boots()->enableRescue(321, [
    'os' => 'linux',
    'arch' => 64
]);

echo "Temp password: " . $rescue->password;
```

---

### Storage Box
```php
// List storage boxes
$boxes = HetznerRobot::storageBoxes()->all();

// Create snapshot
$snapshot = HetznerRobot::storageBoxes()->createSnapshot($boxId);

// Get snapshot plan
$plan = HetznerRobot::storageBoxes()->getSnapshotPlan($boxId);

// Create sub-account
$sub = HetznerRobot::storageBoxes()->createSubAccount($boxId, [
    'homedirectory' => 'backup_sub'
]);
```

---

### Firewall Configuration
```php
// Find firewall for server
$firewall = HetznerRobot::firewalls()->find(321);

// Create or update firewall rules
HetznerRobot::firewalls()->create(321, [
    'status' => 'active',
    'filter_ipv6' => false,
    'whitelist_hos' => true,
    'rules' => [
        'input' => [
            [
                'name' => 'Allow HTTP',
                'ip_version' => 'ipv4',
                'dst_port' => '80',
                'action' => 'accept'
            ]
        ]
    ]
]);
```

---

### vSwitches
```php
// List vswitches
$vswitches = HetznerRobot::vswitches()->all();

// Create vswitch
$vswitch = HetznerRobot::vswitches()->create([
    'name' => 'vswitch-prod',
    'vlan' => 4000
]);

// Add servers to vswitch
HetznerRobot::vswitches()->addServers($vswitch->id, [321, 421]);
```

---

### Asynchronous Requests
```php
use GuzzleHttp\Promise\PromiseInterface;

// Return a Guzzle Promise immediately
$promise = HetznerRobot::servers()->async()->all();

// Resolve promise when ready
$servers = $promise->wait();
```

---

### Batch Concurrent Operations
```php
// Execute multiple queries concurrently
$results = HetznerRobot::batch([
    fn () => HetznerRobot::servers()->find(321),
    fn () => HetznerRobot::servers()->find(421),
    fn () => HetznerRobot::storageBoxes()->find(123456),
]);

$server1 = $results[0];
$server2 = $results[1];
$storageBox = $results[2];
```

---

### Exception Handling
All exceptions inherit from `Vendor\HetznerRobot\Exceptions\HetznerException`.

```php
use Vendor\HetznerRobot\Exceptions\AuthenticationException;
use Vendor\HetznerRobot\Exceptions\ValidationException;
use Vendor\HetznerRobot\Exceptions\RateLimitException;
use Vendor\HetznerRobot\Exceptions\HetznerException;

try {
    HetznerRobot::servers()->update(321, []);
} catch (AuthenticationException $e) {
    // 401 Unauthorized
} catch (ValidationException $e) {
    // 400 Bad Request / INVALID_INPUT
    $missingFields = $e->getMissingFields();
    $invalidFields = $e->getInvalidFields();
} catch (RateLimitException $e) {
    // 403 Rate Limit Exceeded
    $maxRequest = $e->getMaxRequest();
} catch (HetznerException $e) {
    // Base exception handler
}
```

---

## Static Analysis & Linting

Run PHPStan static analysis:
```bash
vendor/bin/phpstan analyse
```

Run Psalm static analysis:
```bash
vendor/bin/psalm
```

Format code with Pint:
```bash
vendor/bin/pint
```

---
