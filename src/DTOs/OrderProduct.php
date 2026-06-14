<?php

namespace Vendor\HetznerRobot\DTOs;

class OrderProduct
{
    public string $id;

    public string $name;

    public array $description = [];

    public string $traffic;

    public array $dist = [];

    public array $lang = [];

    public array $location = [];

    public array $prices = [];

    public array $orderableAddons = [];

    public array $arch = [];

    public string $cpu = '';

    public int $cpuBenchmark = 0;

    public int $memorySize = 0;

    public int $hddSize = 0;

    public string $hddText = '';

    public int $hddCount = 0;

    public string $datacenter = '';

    public string $networkSpeed = '';

    public float $price = 0.0;

    public float $priceHourly = 0.0;

    public float $priceSetup = 0.0;

    public float $priceVat = 0.0;

    public float $priceHourlyVat = 0.0;

    public float $priceSetupVat = 0.0;

    public bool $fixedPrice = false;

    public int $nextReduce = 0;

    public string $nextReduceDate = '';

    public static function fromArray(array $data): self
    {
        $product = new self;
        $product->id = (string) ($data['id'] ?? '');
        $product->name = (string) ($data['name'] ?? '');
        $product->description = (array) ($data['description'] ?? []);
        $product->traffic = (string) ($data['traffic'] ?? '');
        $product->dist = (array) ($data['dist'] ?? []);
        $product->lang = (array) ($data['lang'] ?? []);
        $product->location = (array) ($data['location'] ?? []);
        $product->prices = (array) ($data['prices'] ?? []);
        $product->orderableAddons = (array) ($data['orderable_addons'] ?? []);
        $product->arch = (array) ($data['arch'] ?? []);
        $product->cpu = (string) ($data['cpu'] ?? '');
        $product->cpuBenchmark = (int) ($data['cpu_benchmark'] ?? 0);
        $product->memorySize = (int) ($data['memory_size'] ?? 0);
        $product->hddSize = (int) ($data['hdd_size'] ?? 0);
        $product->hddText = (string) ($data['hdd_text'] ?? '');
        $product->hddCount = (int) ($data['hdd_count'] ?? 0);
        $product->datacenter = (string) ($data['datacenter'] ?? '');
        $product->networkSpeed = (string) ($data['network_speed'] ?? '');
        $product->price = (float) ($data['price'] ?? 0.0);
        $product->priceHourly = (float) ($data['price_hourly'] ?? 0.0);
        $product->priceSetup = (float) ($data['price_setup'] ?? 0.0);
        $product->priceVat = (float) ($data['price_vat'] ?? 0.0);
        $product->priceHourlyVat = (float) ($data['price_hourly_vat'] ?? 0.0);
        $product->priceSetupVat = (float) ($data['price_setup_vat'] ?? 0.0);
        $product->fixedPrice = (bool) ($data['fixed_price'] ?? false);
        $product->nextReduce = (int) ($data['next_reduce'] ?? 0);
        $product->nextReduceDate = (string) ($data['next_reduce_date'] ?? '');

        return $product;
    }
}
