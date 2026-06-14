# Hetzner Robot API Endpoints to SDK Methods Mapping

This document maps every endpoint in the Hetzner Robot Web Service API to its corresponding SDK manager method.

## Servers

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/server` | `HetznerRobot::servers()->all()` |
| `GET` | `/server/{server-number}` | `HetznerRobot::servers()->find($serverNumber)` |
| `POST` | `/server/{server-number}` | `HetznerRobot::servers()->update($serverNumber, $data)` |
| `GET` | `/server/{server-number}/cancellation` | `HetznerRobot::servers()->getCancellation($serverNumber)` |
| `POST` | `/server/{server-number}/cancellation` | `HetznerRobot::servers()->createCancellation($serverNumber, $data)` |
| `DELETE` | `/server/{server-number}/cancellation` | `HetznerRobot::servers()->deleteCancellation($serverNumber)` |

## IPs

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/ip` | `HetznerRobot::ips()->all()` |
| `GET` | `/ip/{ip}` | `HetznerRobot::ips()->find($ip)` |
| `POST` | `/ip/{ip}` | `HetznerRobot::ips()->update($ip, $data)` |
| `GET` | `/ip/{ip}/mac` | `HetznerRobot::ips()->getMac($ip)` |
| `PUT` | `/ip/{ip}/mac` | `HetznerRobot::ips()->updateMac($ip, $mac)` |
| `DELETE` | `/ip/{ip}/mac` | `HetznerRobot::ips()->deleteMac($ip)` |
| `GET` | `/ip/{ip}/cancellation` | `HetznerRobot::ips()->getCancellation($ip)` |
| `POST` | `/ip/{ip}/cancellation` | `HetznerRobot::ips()->createCancellation($ip, $data)` |
| `DELETE` | `/ip/{ip}/cancellation` | `HetznerRobot::ips()->deleteCancellation($ip)` |

## Subnets

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/subnet` | `HetznerRobot::subnets()->all()` |
| `GET` | `/subnet/{net-ip}` | `HetznerRobot::subnets()->find($netIp)` |
| `POST` | `/subnet/{net-ip}` | `HetznerRobot::subnets()->update($netIp, $data)` |
| `GET` | `/subnet/{net-ip}/mac` | `HetznerRobot::subnets()->getMac($netIp)` |
| `PUT` | `/subnet/{net-ip}/mac` | `HetznerRobot::subnets()->updateMac($netIp, $mac)` |
| `DELETE` | `/subnet/{net-ip}/mac` | `HetznerRobot::subnets()->deleteMac($netIp)` |
| `GET` | `/subnet/{net-ip}/cancellation` | `HetznerRobot::subnets()->getCancellation($netIp)` |
| `POST` | `/subnet/{net-ip}/cancellation` | `HetznerRobot::subnets()->createCancellation($netIp, $data)` |
| `DELETE` | `/subnet/{ip}/cancellation` | `HetznerRobot::subnets()->deleteCancellation($netIp)` |

## Resets

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/reset` | `HetznerRobot::resets()->all()` |
| `GET` | `/reset/{server-number}` | `HetznerRobot::resets()->find($serverNumber)` |
| `POST` | `/reset/{server-number}` | `HetznerRobot::resets()->create($serverNumber, $data)` |

## Failovers

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/failover` | `HetznerRobot::failovers()->all()` |
| `GET` | `/failover/{failover-ip}` | `HetznerRobot::failovers()->find($failoverIp)` |
| `POST` | `/failover/{failover-ip}` | `HetznerRobot::failovers()->update($failoverIp, $activeServerIp)` |
| `DELETE` | `/failover/{failover-ip}` | `HetznerRobot::failovers()->delete($failoverIp)` |

## Wake on LAN

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/wol/{server-number}` | `HetznerRobot::wols()->find($serverNumber)` |
| `POST` | `/wol/{server-number}` | `HetznerRobot::wols()->send($serverNumber)` |

## Boot Configurations

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/boot/{server-number}` | `HetznerRobot::boots()->find($serverNumber)` |
| `GET` | `/boot/{server-number}/rescue` | `HetznerRobot::boots()->getRescue($serverNumber)` |
| `POST` | `/boot/{server-number}/rescue` | `HetznerRobot::boots()->enableRescue($serverNumber, $data)` |
| `DELETE` | `/boot/{server-number}/rescue` | `HetznerRobot::boots()->disableRescue($serverNumber)` |
| `GET` | `/boot/{server-number}/rescue/last` | `HetznerRobot::boots()->getLastRescue($serverNumber)` |
| `GET` | `/boot/{server-number}/linux` | `HetznerRobot::boots()->getLinux($serverNumber)` |
| `POST` | `/boot/{server-number}/linux` | `HetznerRobot::boots()->enableLinux($serverNumber, $data)` |
| `DELETE` | `/boot/{server-number}/linux` | `HetznerRobot::boots()->disableLinux($serverNumber)` |
| `GET` | `/boot/{server-number}/linux/last` | `HetznerRobot::boots()->getLastLinux($serverNumber)` |
| `GET` | `/boot/{server-number}/vnc` | `HetznerRobot::boots()->getVnc($serverNumber)` |
| `POST` | `/boot/{server-number}/vnc` | `HetznerRobot::boots()->enableVnc($serverNumber, $data)` |
| `DELETE` | `/boot/{server-number}/vnc` | `HetznerRobot::boots()->disableVnc($serverNumber)` |
| `GET` | `/boot/{server-number}/windows` | `HetznerRobot::boots()->getWindows($serverNumber)` |
| `POST` | `/boot/{server-number}/windows` | `HetznerRobot::boots()->enableWindows($serverNumber, $data)` |
| `DELETE` | `/boot/{server-number}/windows` | `HetznerRobot::boots()->disableWindows($serverNumber)` |

## Reverse DNS

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/rdns` | `HetznerRobot::rdns()->all()` |
| `GET` | `/rdns/{ip}` | `HetznerRobot::rdns()->find($ip)` |
| `PUT` | `/rdns/{ip}` | `HetznerRobot::rdns()->update($ip, $ptr)` |
| `POST` | `/rdns/{ip}` | `HetznerRobot::rdns()->create($ip, $ptr)` |
| `DELETE` | `/rdns/{ip}` | `HetznerRobot::rdns()->delete($ip)` |

## Traffic

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `POST` | `/traffic` | `HetznerRobot::traffic()->query($data)` |

## SSH Keys

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/key` | `HetznerRobot::sshKeys()->all()` |
| `POST` | `/key` | `HetznerRobot::sshKeys()->create($data)` |
| `GET` | `/key/{fingerprint}` | `HetznerRobot::sshKeys()->find($fingerprint)` |
| `POST` | `/key/{fingerprint}` | `HetznerRobot::sshKeys()->update($fingerprint, $data)` |
| `DELETE` | `/key/{fingerprint}` | `HetznerRobot::sshKeys()->delete($fingerprint)` |

## Ordering

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/order/server/product` | `HetznerRobot::orders()->getServerProducts()` |
| `GET` | `/order/server/product/{product-id}` | `HetznerRobot::orders()->getServerProduct($productId)` |
| `GET` | `/order/server/transaction` | `HetznerRobot::orders()->getServerTransactions()` |
| `POST` | `/order/server/transaction` | `HetznerRobot::orders()->orderServer($data)` |
| `GET` | `/order/server/transaction/{id}` | `HetznerRobot::orders()->getServerTransaction($transactionId)` |
| `GET` | `/order/server_market/product` | `HetznerRobot::orders()->getMarketProducts()` |
| `GET` | `/order/server_market/product/{product-id}` | `HetznerRobot::orders()->getMarketProduct($productId)` |
| `GET` | `/order/server_market/transaction` | `HetznerRobot::orders()->getMarketTransactions()` |
| `POST` | `/order/server_market/transaction` | `HetznerRobot::orders()->orderMarket($data)` |
| `GET` | `/order/server_market/transaction/{id}` | `HetznerRobot::orders()->getMarketTransaction($transactionId)` |
| `GET` | `/order/server_addon/{server-number}/product` | `HetznerRobot::orders()->getAddonProducts($serverNumber)` |
| `GET` | `/order/server_addon/transaction` | `HetznerRobot::orders()->getAddonTransactions()` |
| `POST` | `/order/server_addon/transaction` | `HetznerRobot::orders()->orderAddon($data)` |
| `GET` | `/order/server_addon/transaction/{id}` | `HetznerRobot::orders()->getAddonTransaction($transactionId)` |
| `GET` | `/order/currency` | `HetznerRobot::orders()->getCurrency()` |

## Storage Boxes

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/storagebox` | `HetznerRobot::storageBoxes()->all()` |
| `GET` | `/storagebox/{storagebox-id}` | `HetznerRobot::storageBoxes()->find($storageBoxId)` |
| `POST` | `/storagebox/{storagebox-id}` | `HetznerRobot::storageBoxes()->update($storageBoxId, $data)` |
| `POST` | `/storagebox/{storagebox-id}/password` | `HetznerRobot::storageBoxes()->updatePassword($storageBoxId, $password)` |
| `GET` | `/storagebox/{storagebox-id}/snapshot` | `HetznerRobot::storageBoxes()->getSnapshots($storageBoxId)` |
| `POST` | `/storagebox/{storagebox-id}/snapshot` | `HetznerRobot::storageBoxes()->createSnapshot($storageBoxId)` |
| `DELETE` | `/storagebox/{storagebox-id}/snapshot/{snapshot-name}` | `HetznerRobot::storageBoxes()->deleteSnapshot($storageBoxId, $snapshotName)` |
| `POST` | `/storagebox/{storagebox-id}/snapshot/{snapshot-name}` | `HetznerRobot::storageBoxes()->revertToSnapshot($storageBoxId, $snapshotName)` |
| `POST` | `/storagebox/{storagebox-id}/snapshot/{snapshot-name}/comment` | `HetznerRobot::storageBoxes()->updateSnapshotComment($storageBoxId, $snapshotName, $comment)` |
| `GET` | `/storagebox/{storagebox-id}/snapshotplan` | `HetznerRobot::storageBoxes()->getSnapshotPlan($storageBoxId)` |
| `POST` | `/storagebox/{storagebox-id}/snapshotplan` | `HetznerRobot::storageBoxes()->updateSnapshotPlan($storageBoxId, $data)` |
| `GET` | `/storagebox/{storagebox-id}/subaccount` | `HetznerRobot::storageBoxes()->getSubAccounts($storageBoxId)` |
| `POST` | `/storagebox/{storagebox-id}/subaccount` | `HetznerRobot::storageBoxes()->createSubAccount($storageBoxId, $data)` |
| `PUT` | `/storagebox/{storagebox-id}/subaccount/{sub-account-username}` | `HetznerRobot::storageBoxes()->updateSubAccount($storageBoxId, $username, $data)` |
| `DELETE` | `/storagebox/{storagebox-id}/subaccount/{sub-account-username}` | `HetznerRobot::storageBoxes()->deleteSubAccount($storageBoxId, $username)` |
| `POST` | `/storagebox/{storagebox-id}/subaccount/{sub-account-username}/password` | `HetznerRobot::storageBoxes()->updateSubAccountPassword($storageBoxId, $username, $password)` |

## Firewalls

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/firewall/{server-id}` | `HetznerRobot::firewalls()->find($serverId)` |
| `POST` | `/firewall/{server-id}` | `HetznerRobot::firewalls()->create($serverId, $data)` |
| `DELETE` | `/firewall/{server-id}` | `HetznerRobot::firewalls()->delete($serverId)` |
| `GET` | `/firewall/template` | `HetznerRobot::firewalls()->getTemplates()` |
| `POST` | `/firewall/template` | `HetznerRobot::firewalls()->createTemplate($data)` |
| `GET` | `/firewall/template/{template-id}` | `HetznerRobot::firewalls()->getTemplate($templateId)` |
| `POST` | `/firewall/template/{template-id}` | `HetznerRobot::firewalls()->updateTemplate($templateId, $data)` |
| `DELETE` | `/firewall/template/{template-id}` | `HetznerRobot::firewalls()->deleteTemplate($templateId)` |

## vSwitches

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/vswitch` | `HetznerRobot::vswitches()->all()` |
| `POST` | `/vswitch` | `HetznerRobot::vswitches()->create($data)` |
| `GET` | `/vswitch/{vswitch-id}` | `HetznerRobot::vswitches()->find($vswitchId)` |
| `POST` | `/vswitch/{vswitch-id}` | `HetznerRobot::vswitches()->update($vswitchId, $data)` |
| `DELETE` | `/vswitch/{vswitch-id}` | `HetznerRobot::vswitches()->delete($vswitchId, $date)` |
| `POST` | `/vswitch/{vswitch-id}/server` | `HetznerRobot::vswitches()->addServers($vswitchId, $servers)` |
| `DELETE` | `/vswitch/{vswitch-id}/server` | `HetznerRobot::vswitches()->removeServers($vswitchId, $servers)` |
