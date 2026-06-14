# Laravel Hetzner Robot SDK - Functions Reference

This file documents every manager, method, helper, and facade call exposed by the package.

---

# Authentication

```php
HetznerRobot::authenticate($username, $password);
```

---

# Servers

```php
HetznerRobot::servers()->all();

HetznerRobot::servers()->find($serverNumber);

HetznerRobot::servers()->update($serverNumber, [
    'server_name' => 'new-name'
]);

HetznerRobot::servers()->getCancellation($serverNumber);

HetznerRobot::servers()->createCancellation($serverNumber, [
    'cancellation_date' => '2026-07-01',
    'cancellation_reason' => 'server_redundant'
]);

HetznerRobot::servers()->deleteCancellation($serverNumber);
```

---

# IPs

```php
HetznerRobot::ips()->all();

HetznerRobot::ips()->find($ip);

HetznerRobot::ips()->update($ip, [
    'traffic_warnings' => 'true'
]);

HetznerRobot::ips()->getMac($ip);

HetznerRobot::ips()->updateMac($ip, $macAddress);

HetznerRobot::ips()->deleteMac($ip);

HetznerRobot::ips()->getCancellation($ip);

HetznerRobot::ips()->createCancellation($ip, [
    'cancellation_date' => 'now'
]);

HetznerRobot::ips()->deleteCancellation($ip);
```

---

# Subnets

```php
HetznerRobot::subnets()->all();

HetznerRobot::subnets()->find($netIp);

HetznerRobot::subnets()->update($netIp, []);

HetznerRobot::subnets()->getMac($netIp);

HetznerRobot::subnets()->updateMac($netIp, $macAddress);

HetznerRobot::subnets()->deleteMac($netIp);

HetznerRobot::subnets()->getCancellation($netIp);

HetznerRobot::subnets()->createCancellation($netIp, [
    'cancellation_date' => 'now'
]);

HetznerRobot::subnets()->deleteCancellation($netIp);
```

---

# Resets

```php
HetznerRobot::resets()->all();

HetznerRobot::resets()->find($serverNumber);

HetznerRobot::resets()->create($serverNumber, [
    'type' => 'hw' // hw, sw, man
]);
```

---

# Failovers

```php
HetznerRobot::failovers()->all();

HetznerRobot::failovers()->find($failoverIp);

HetznerRobot::failovers()->update($failoverIp, $activeServerIp);

HetznerRobot::failovers()->delete($failoverIp);
```

---

# Wake-on-LAN

```php
HetznerRobot::wols()->find($serverNumber);

HetznerRobot::wols()->send($serverNumber);
```

---

# Boot Configuration (Rescue, Linux, Windows, VNC)

```php
HetznerRobot::boots()->find($serverNumber);

// Rescue boot
HetznerRobot::boots()->getRescue($serverNumber);
HetznerRobot::boots()->enableRescue($serverNumber, [
    'os' => 'linux',
    'arch' => 64,
    'authorized_key' => 'fingerprint_here'
]);
HetznerRobot::boots()->disableRescue($serverNumber);
HetznerRobot::boots()->getLastRescue($serverNumber);

// Linux boot
HetznerRobot::boots()->getLinux($serverNumber);
HetznerRobot::boots()->enableLinux($serverNumber, [
    'dist' => 'Debian 12 minimal',
    'arch' => 64,
    'lang' => 'en'
]);
HetznerRobot::boots()->disableLinux($serverNumber);
HetznerRobot::boots()->getLastLinux($serverNumber);

// VNC boot
HetznerRobot::boots()->getVnc($serverNumber);
HetznerRobot::boots()->enableVnc($serverNumber, [
    'dist' => 'CentOS 7 minimal',
    'arch' => 64
]);
HetznerRobot::boots()->disableVnc($serverNumber);

// Windows boot
HetznerRobot::boots()->getWindows($serverNumber);
HetznerRobot::boots()->enableWindows($serverNumber, [
    'dist' => 'Windows Server 2022 Standard',
    'lang' => 'en'
]);
HetznerRobot::boots()->disableWindows($serverNumber);
```

---

# Reverse DNS

```php
HetznerRobot::rdns()->all();

HetznerRobot::rdns()->find($ip);

HetznerRobot::rdns()->create($ip, $ptr);

HetznerRobot::rdns()->update($ip, $ptr);

HetznerRobot::rdns()->delete($ip);
```

---

# Traffic

```php
HetznerRobot::traffic()->query([
    'type' => 'month',
    'from' => '2026-06-01',
    'to' => '2026-06-30',
    'ip' => ['123.123.123.123']
]);
```

---

# SSH Keys

```php
HetznerRobot::sshKeys()->all();

HetznerRobot::sshKeys()->find($fingerprint);

HetznerRobot::sshKeys()->create([
    'name' => 'my-key',
    'data' => 'ssh-rsa ...'
]);

HetznerRobot::sshKeys()->update($fingerprint, [
    'name' => 'updated-key-name'
]);

HetznerRobot::sshKeys()->delete($fingerprint);
```

---

# Ordering

```php
// Server Ordering
HetznerRobot::orders()->getServerProducts();
HetznerRobot::orders()->getServerProduct($productId);
HetznerRobot::orders()->getServerTransactions();
HetznerRobot::orders()->getServerTransaction($transactionId);
HetznerRobot::orders()->orderServer([
    'product_id' => 'EX44',
    'authorized_key' => 'fingerprint_here',
    'addon' => ['primary_ipv4']
]);

// Server Market Ordering
HetznerRobot::orders()->getMarketProducts();
HetznerRobot::orders()->getMarketProduct($productId);
HetznerRobot::orders()->getMarketTransactions();
HetznerRobot::orders()->getMarketTransaction($transactionId);
HetznerRobot::orders()->orderMarket([
    'product_id' => 'EX60_1',
    'authorized_key' => 'fingerprint_here'
]);

// Addon Ordering
HetznerRobot::orders()->getAddonProducts($serverNumber);
HetznerRobot::orders()->getAddonTransactions();
HetznerRobot::orders()->getAddonTransaction($transactionId);
HetznerRobot::orders()->orderAddon([
    'server_number' => 321,
    'product_id' => 'subnet_29'
]);

// Currency Info
HetznerRobot::orders()->getCurrency();
```

---

# Storage Boxes

```php
HetznerRobot::storageBoxes()->all();

HetznerRobot::storageBoxes()->find($storageBoxId);

HetznerRobot::storageBoxes()->update($storageBoxId, [
    'storagebox_name' => 'backup-disk-1'
]);

HetznerRobot::storageBoxes()->updatePassword($storageBoxId, 'secret-password');

// Snapshots
HetznerRobot::storageBoxes()->getSnapshots($storageBoxId);
HetznerRobot::storageBoxes()->createSnapshot($storageBoxId);
HetznerRobot::storageBoxes()->deleteSnapshot($storageBoxId, $snapshotName);
HetznerRobot::storageBoxes()->revertToSnapshot($storageBoxId, $snapshotName);
HetznerRobot::storageBoxes()->updateSnapshotComment($storageBoxId, $snapshotName, 'Comment text');

// Snapshot Plan
HetznerRobot::storageBoxes()->getSnapshotPlan($storageBoxId);
HetznerRobot::storageBoxes()->updateSnapshotPlan($storageBoxId, [
    'status' => 'enabled',
    'hour' => 12,
    'minute' => 0,
    'max_snapshots' => 3
]);

// Sub-accounts
HetznerRobot::storageBoxes()->getSubAccounts($storageBoxId);
HetznerRobot::storageBoxes()->createSubAccount($storageBoxId, [
    'homedirectory' => 'sub_home'
]);
HetznerRobot::storageBoxes()->updateSubAccount($storageBoxId, $username, [
    'samba' => 'false'
]);
HetznerRobot::storageBoxes()->deleteSubAccount($storageBoxId, $username);
HetznerRobot::storageBoxes()->updateSubAccountPassword($storageBoxId, $username, 'new-password');
```

---

# Firewalls

```php
HetznerRobot::firewalls()->find($serverId);

HetznerRobot::firewalls()->create($serverId, [
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

HetznerRobot::firewalls()->delete($serverId);

// Templates
HetznerRobot::firewalls()->getTemplates();
HetznerRobot::firewalls()->getTemplate($templateId);
HetznerRobot::firewalls()->createTemplate([
    'name' => 'My standard rules',
    'filter_ipv6' => false,
    'whitelist_hos' => true,
    'rules' => [
        'input' => [
            [
                'name' => 'Allow SSH',
                'ip_version' => 'ipv4',
                'dst_port' => '22',
                'action' => 'accept'
            ]
        ]
    ]
]);
HetznerRobot::firewalls()->updateTemplate($templateId, []);
HetznerRobot::firewalls()->deleteTemplate($templateId);
```

---

# vSwitches

```php
HetznerRobot::vswitches()->all();

HetznerRobot::vswitches()->find($vswitchId);

HetznerRobot::vswitches()->create([
    'name' => 'vswitch-prod',
    'vlan' => 4000
]);

HetznerRobot::vswitches()->update($vswitchId, [
    'name' => 'vswitch-stage'
]);

HetznerRobot::vswitches()->delete($vswitchId, 'now');

HetznerRobot::vswitches()->addServers($vswitchId, [321, 421]);

HetznerRobot::vswitches()->removeServers($vswitchId, [321, 421]);
```

---

# Async Requests

```php
HetznerRobot::servers()->async()->all();

HetznerRobot::storageBoxes()->async()->all();
```

---

# Batch Operations

```php
HetznerRobot::batch([
    fn () => HetznerRobot::servers()->find(321),
    fn () => HetznerRobot::servers()->find(421),
    fn () => HetznerRobot::storageBoxes()->find(123456),
]);
```

---

# Helper Methods

```php
HetznerRobot::ping();

HetznerRobot::version();

HetznerRobot::rateLimit();

HetznerRobot::health();

HetznerRobot::config();

HetznerRobot::client();
```
