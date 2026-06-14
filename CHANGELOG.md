# Changelog

All notable changes to this project will be documented in this file.

## [1.0.0] - 2026-06-14

### Added
- Initial release of the production-ready Hetzner Robot Laravel SDK.
- 100% coverage of all Hetzner Robot API resources: Servers, IPs, Subnets, Resets, Failovers, Wake-on-LAN, Boot configurations, Reverse DNS, Traffic, SSH Keys, Ordering products, Storage Boxes, Firewalls, and vSwitches.
- Exponential backoff retry middleware with automatic parsing for `RATE_LIMIT_EXCEEDED` statuses.
- Concurrency via Guzzle promise mapping for asynchronous calls and batch requests.
- Custom exception mapping for all HTTP error statuses.
- Configuration publish, service provider container binds, and Laravel Facade support.
- Fully compatible with PHP 8.2 through PHP 8.5.
- Supported on Laravel 11 through Laravel 13.
