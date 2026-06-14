<?php

namespace Vendor\HetznerRobot\Managers;

use Vendor\HetznerRobot\DTOs\OrderProduct;
use Vendor\HetznerRobot\DTOs\OrderTransaction;

class OrderManager extends AbstractManager
{
    // Dedicated Server Products & Transactions
    public function getServerProducts(): mixed
    {
        $response = $this->getRequest('order/server/product');

        return $this->hydrate($response, function (array $data) {
            $products = array_map(function (array $item) {
                return OrderProduct::fromArray($item['product'] ?? []);
            }, $data);

            return collect($products);
        });
    }

    public function getServerProduct(string $productId): mixed
    {
        $response = $this->getRequest("order/server/product/{$productId}");

        return $this->hydrate($response, function (array $data) {
            return OrderProduct::fromArray($data['product'] ?? []);
        });
    }

    public function getServerTransactions(): mixed
    {
        $response = $this->getRequest('order/server/transaction');

        return $this->hydrate($response, function (array $data) {
            $transactions = array_map(function (array $item) {
                return OrderTransaction::fromArray($item['transaction'] ?? []);
            }, $data);

            return collect($transactions);
        });
    }

    public function getServerTransaction(string $transactionId): mixed
    {
        $response = $this->getRequest("order/server/transaction/{$transactionId}");

        return $this->hydrate($response, function (array $data) {
            return OrderTransaction::fromArray($data['transaction'] ?? []);
        });
    }

    public function orderServer(array $data): mixed
    {
        $response = $this->postRequest('order/server/transaction', $data);

        return $this->hydrate($response, function (array $data) {
            return OrderTransaction::fromArray($data['transaction'] ?? []);
        });
    }

    // Server Market Products & Transactions
    public function getMarketProducts(): mixed
    {
        $response = $this->getRequest('order/server_market/product');

        return $this->hydrate($response, function (array $data) {
            $products = array_map(function (array $item) {
                return OrderProduct::fromArray($item['product'] ?? []);
            }, $data);

            return collect($products);
        });
    }

    public function getMarketProduct(string $productId): mixed
    {
        $response = $this->getRequest("order/server_market/product/{$productId}");

        return $this->hydrate($response, function (array $data) {
            return OrderProduct::fromArray($data['product'] ?? []);
        });
    }

    public function getMarketTransactions(): mixed
    {
        $response = $this->getRequest('order/server_market/transaction');

        return $this->hydrate($response, function (array $data) {
            $transactions = array_map(function (array $item) {
                return OrderTransaction::fromArray($item['transaction'] ?? []);
            }, $data);

            return collect($transactions);
        });
    }

    public function getMarketTransaction(string $transactionId): mixed
    {
        $response = $this->getRequest("order/server_market/transaction/{$transactionId}");

        return $this->hydrate($response, function (array $data) {
            return OrderTransaction::fromArray($data['transaction'] ?? []);
        });
    }

    public function orderMarket(array $data): mixed
    {
        $response = $this->postRequest('order/server_market/transaction', $data);

        return $this->hydrate($response, function (array $data) {
            return OrderTransaction::fromArray($data['transaction'] ?? []);
        });
    }

    // Addon Products & Transactions
    public function getAddonProducts(int $serverNumber): mixed
    {
        $response = $this->getRequest("order/server_addon/{$serverNumber}/product");

        return $this->hydrate($response, function (array $data) {
            $products = array_map(function (array $item) {
                return OrderProduct::fromArray($item['product'] ?? []);
            }, $data);

            return collect($products);
        });
    }

    public function getAddonTransactions(): mixed
    {
        $response = $this->getRequest('order/server_addon/transaction');

        return $this->hydrate($response, function (array $data) {
            $transactions = array_map(function (array $item) {
                return OrderTransaction::fromArray($item['transaction'] ?? []);
            }, $data);

            return collect($transactions);
        });
    }

    public function getAddonTransaction(string $transactionId): mixed
    {
        $response = $this->getRequest("order/server_addon/transaction/{$transactionId}");

        return $this->hydrate($response, function (array $data) {
            return OrderTransaction::fromArray($data['transaction'] ?? []);
        });
    }

    public function orderAddon(array $data): mixed
    {
        $response = $this->postRequest('order/server_addon/transaction', $data);

        return $this->hydrate($response, function (array $data) {
            return OrderTransaction::fromArray($data['transaction'] ?? []);
        });
    }

    // Currency
    public function getCurrency(): mixed
    {
        return $this->getRequest('order/currency');
    }
}
