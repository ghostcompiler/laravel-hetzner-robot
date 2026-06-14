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

        return $product;
    }
}
